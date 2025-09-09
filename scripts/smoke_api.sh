#!/usr/bin/env bash
set -euo pipefail

# Smoke test for Laravel API endpoints in this project.
# Usage:
#   bash scripts/smoke_api.sh [BASE_URL]
# Example:
#   bash scripts/smoke_api.sh            # defaults to http://127.0.0.1:8000
#   bash scripts/smoke_api.sh http://localhost:8000

BASE_URL=${1:-http://127.0.0.1:8000}
API="$BASE_URL/api"

info()  { echo -e "\033[1;34m[INFO]\033[0m $*"; }
ok()    { echo -e "\033[1;32m[ OK ]\033[0m $*"; }
err()   { echo -e "\033[1;31m[FAIL]\033[0m $*"; }

TMP_DIR=$(mktemp -d)
trap 'rm -rf "$TMP_DIR"' EXIT

have_jq=0
if command -v jq >/dev/null 2>&1; then have_jq=1; fi

show_body() {
  if (( have_jq )); then
    jq . -r 2>/dev/null || cat
  else
    cat
  fi
}

extract_id() {
  local file=$1
  if (( have_jq )); then
    jq -r 'try .id // empty' "$file"
  else
    sed -nE 's/.*"id"\s*:\s*([0-9]+).*/\1/p' "$file" | head -n1
  fi
}

curl_req() {
  local method=$1; shift
  local url=$1; shift
  local body=${1:-}
  local out="$TMP_DIR/resp.json"
  local code

  if [[ -n "$body" ]]; then
    code=$(curl -sS -o "$out" -w '%{http_code}' -X "$method" -H 'Content-Type: application/json' -d "$body" "$url")
  else
    code=$(curl -sS -o "$out" -w '%{http_code}' -X "$method" "$url")
  fi
  echo "$code" "$out"
}

expect_code() {
  local got=$1 expected=$2 ctx=$3
  if [[ "$got" != "$expected" ]]; then
    err "$ctx → expected $expected, got $got"
    exit 1
  fi
}

info "Base URL: $BASE_URL"

# 1) List logs
info "GET /api/logs"
read -r code file < <(curl_req GET "$API/logs")
expect_code "$code" 200 "GET /api/logs"
show_body < "$file"
ok "GET /api/logs ($code)"

# 2) Create a log
payload='{"komponen_terdeteksi":"sensor_demo","status":"ok"}'
info "POST /api/logs"
read -r code file < <(curl_req POST "$API/logs" "$payload")
expect_code "$code" 201 "POST /api/logs"
show_body < "$file"
ID=$(extract_id "$file")
if [[ -z "$ID" ]]; then
  err "Tidak bisa mengekstrak id dari respons create"
  exit 1
fi
ok "POST /api/logs → id=$ID ($code)"

# 3) Get one
info "GET /api/logs/$ID"
read -r code file < <(curl_req GET "$API/logs/$ID")
expect_code "$code" 200 "GET /api/logs/$ID"
show_body < "$file"
ok "GET /api/logs/$ID ($code)"

# 4) Update
payload='{"status":"failed"}'
info "PUT /api/logs/$ID"
read -r code file < <(curl_req PUT "$API/logs/$ID" "$payload")
expect_code "$code" 200 "PUT /api/logs/$ID"
show_body < "$file"
ok "PUT /api/logs/$ID ($code)"

# 5) Filter by status
info "GET /api/logs/status/failed"
read -r code file < <(curl_req GET "$API/logs/status/failed")
expect_code "$code" 200 "GET /api/logs/status/failed"
show_body < "$file"
ok "GET /api/logs/status/failed ($code)"

# 6) Delete
info "DELETE /api/logs/$ID"
read -r code file < <(curl_req DELETE "$API/logs/$ID")
expect_code "$code" 200 "DELETE /api/logs/$ID"
show_body < "$file"
ok "DELETE /api/logs/$ID ($code)"

ok "Smoke tests selesai tanpa error."

