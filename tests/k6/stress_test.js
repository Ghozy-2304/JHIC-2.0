import http from 'k6/http';
import { check, sleep } from 'k6';

/**
 * k6 High-Intensity Stress Test Script for JHIC Laravel Application
 * 
 * Objectives:
 * Find the maximum capacity / breaking point of the server by gradually
 * scaling up Virtual Users (VUs) from 50 up to 1,000 concurrent users.
 */

export const options = {
    stages: [
        { duration: '30s', target: 50 },   // Step 1: 50 VUs (Light load)
        { duration: '1m',  target: 100 },  // Step 2: 100 VUs (Moderate load)
        { duration: '1m',  target: 300 },  // Step 3: 300 VUs (Heavy load)
        { duration: '1m',  target: 500 },  // Step 4: 500 VUs (High Stress)
        { duration: '1m',  target: 1000 }, // Step 5: 1000 VUs (Extreme Stress / Capacity Limit)
        { duration: '30s', target: 0 },    // Ramp-down to 0
    ],
    thresholds: {
        http_req_failed: ['rate<0.10'],    // Max 10% errors allowed under extreme stress
        http_req_duration: ['p(90)<3000'], // 90% requests under 3s
    },
};

// Target Base URL (Default to local serve or environment variable)
const BASE_URL = __ENV.TARGET_URL || 'http://127.0.0.1:8000';

export default function () {
    // 1. Homepage
    const resHome = http.get(`${BASE_URL}/`);
    check(resHome, {
        'Home status 200': (r) => r.status === 200,
    });
    sleep(1);

    // 2. Articles Index (/artikel)
    const resArticles = http.get(`${BASE_URL}/artikel`);
    check(resArticles, {
        'Artikel Index status 200': (r) => r.status === 200,
    });
    sleep(1);

    // 3. Career Center (/career-center)
    const resCareer = http.get(`${BASE_URL}/career-center`);
    check(resCareer, {
        'Career Center status 200': (r) => r.status === 200,
    });
    sleep(1);

    // 4. PPDB Page (/ppdb)
    const resPpdb = http.get(`${BASE_URL}/ppdb`);
    check(resPpdb, {
        'PPDB status 200': (r) => r.status === 200,
    });
    sleep(1);
}
