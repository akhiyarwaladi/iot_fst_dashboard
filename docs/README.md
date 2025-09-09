# Documentation Directory

This directory contains all project documentation files for the IoT Component Tester dashboard.

## Files

### 📚 API_DOCUMENTATION.md
Complete API documentation covering all REST endpoints for IoT device integration:
- **GET /api/logs** - Retrieve all test logs
- **POST /api/logs** - Create new test log
- **GET /api/logs/{id}** - Get specific log
- **PUT /api/logs/{id}** - Update existing log
- **DELETE /api/logs/{id}** - Delete log
- **GET /api/logs/status/{status}** - Filter logs by status

**Features**:
- ✅ Complete endpoint documentation
- ✅ Request/response examples
- ✅ Multiple programming language examples (JavaScript, Python, Arduino/C++)
- ✅ Error handling and status codes
- ✅ Authentication and security guidelines
- ✅ Performance optimization tips
- ✅ Testing and troubleshooting guides

**Status**: All endpoints tested and fully functional

## Usage

Refer to `API_DOCUMENTATION.md` for complete API integration details when:
- Developing IoT devices that send test data
- Building client applications
- Integrating with external systems
- Troubleshooting API issues

## Related Documentation

For codebase understanding, see the CLAUDE.md files in each project directory:
- `/CLAUDE.md` - Project overview
- `/app/CLAUDE.md` - Application logic
- `/routes/CLAUDE.md` - Route definitions
- `/database/CLAUDE.md` - Database schema
- `/resources/CLAUDE.md` - Frontend assets
- `/config/CLAUDE.md` - Configuration
- `/public/CLAUDE.md` - Static assets