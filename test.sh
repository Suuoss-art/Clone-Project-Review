#!/bin/bash

# Quick deployment test script for Clone Project Review
echo "=== Clone Project Review - Quick Test Script ==="
echo "Testing fundamental functionality..."
echo

# Test 1: Check Laravel is working
echo "1. Testing Laravel Application..."
if php artisan --version > /dev/null 2>&1; then
    echo "   ✓ Laravel is working"
else
    echo "   ✗ Laravel not working"
    exit 1
fi

# Test 2: Check database connection
echo "2. Testing Database Connection..."
if php artisan tinker --execute="DB::connection()->getPdo(); echo 'Connected';" 2>/dev/null | grep -q "Connected"; then
    echo "   ✓ Database connection successful"
else
    echo "   ✗ Database connection failed"
    echo "   Run: php artisan migrate --seed"
    exit 1
fi

# Test 3: Check routes are loaded
echo "3. Testing Routes..."
ROUTE_COUNT=$(php artisan route:list 2>/dev/null | wc -l)
if [ "$ROUTE_COUNT" -gt 10 ]; then
    echo "   ✓ Routes loaded successfully ($ROUTE_COUNT routes)"
else
    echo "   ✗ Routes not properly loaded"
    exit 1
fi

# Test 4: Check user data
echo "4. Testing User Data..."
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -1)
if [ "$USER_COUNT" -ge 4 ]; then
    echo "   ✓ Users seeded correctly ($USER_COUNT users)"
else
    echo "   ✗ User data missing - run: php artisan db:seed"
    exit 1
fi

# Test 5: Check web server (if running)
echo "5. Testing Web Server..."
if curl -s http://127.0.0.1:8000/ > /dev/null 2>&1; then
    echo "   ✓ Web server responding on port 8000"
elif curl -s http://localhost/ > /dev/null 2>&1; then
    echo "   ✓ Web server responding on port 80"
else
    echo "   ⚠ Web server not detected"
    echo "   Start with: php artisan serve"
fi

echo
echo "=== All tests passed! ==="
echo "Login credentials:"
echo "- Admin: admin@example.com / password"
echo "- PM: pm@example.com / password"
echo "- Staff: staff@example.com / password"
echo "- HOD: hod@example.com / password"
echo
echo "To start queue worker for notifications:"
echo "php artisan queue:work"
echo
echo "Application is ready to use!"