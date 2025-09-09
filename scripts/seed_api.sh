#!/usr/bin/env bash
set -euo pipefail

# Seed N demo LogTester rows via the public API.
# Usage:
#   bash scripts/seed_api.sh [BASE_URL] [COUNT]
# Examples:
#   bash scripts/seed_api.sh                  # 20 rows to http://127.0.0.1:8000
#   bash scripts/seed_api.sh http://host 50   # 50 rows to given host

BASE_URL=${1:-http://iot.fst.unja.ac.id}
COUNT=${2:-20}

API="$BASE_URL/api"
comps=(dht11 mq2 relay cam pir ultrasonic rain light sound)
stats=(ok warn failed)

info() { echo -e "\033[1;34m[INFO]\033[0m $*"; }
ok()   { echo -e "\033[1;32m[ OK ]\033[0m $*"; }
err()  { echo -e "\033[1;31m[FAIL]\033[0m $*"; }

created=0
failed=0

info "Seeding $COUNT rows to $API/logs"
for i in $(seq 1 "$COUNT"); do
  c=${comps[$RANDOM % ${#comps[@]}]}
  s=${stats[$RANDOM % ${#stats[@]}]}
  name="${c}-${i}"
  payload=$(printf '{"komponen_terdeteksi":"%s","status":"%s"}' "$name" "$s")

  code=$(curl -sS -o /dev/null -w '%{http_code}' -X POST \
    -H 'Content-Type: application/json' \
    -d "$payload" \
    "$API/logs") || code=000

  if [[ "$code" == "201" ]]; then
    created=$((created+1))
    printf "\r[ %3d/%3d ] created: %-16s status=%s" "$created" "$COUNT" "$name" "$s"
  else
    failed=$((failed+1))
    printf "\r"; err "POST failed (HTTP $code) for $name"; printf "\r"
  fi
done

echo
ok "Done. created=$created failed=$failed"

