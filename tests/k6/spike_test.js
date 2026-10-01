import http from 'k6/http';
import { check, sleep } from 'k6';

/**
 * k6 Spike Test Script for JHIC Laravel Application
 * 
 * Objectives:
 * 1. Warm up at 10 Virtual Users (VUs).
 * 2. Sudden SPIKE surge to 200 VUs in 10 seconds.
 * 3. Hold high traffic for 1 minute to test system resilience under stress.
 * 4. Ramp down to 10 VUs and check if the application recovers gracefully.
 */

export const options = {
    stages: [
        { duration: '20s', target: 10 },   // Normal traffic (warmup)
        { duration: '10s', target: 200 },  // SPIKE! Sudden surge to 200 VUs
        { duration: '1m',  target: 200 },  // Hold peak spike for 1 min
        { duration: '10s', target: 10 },   // Fast ramp-down to 10 VUs
        { duration: '20s', target: 10 },   // Recovery phase
        { duration: '10s', target: 0 },    // Cooldown
    ],
    thresholds: {
        http_req_failed: ['rate<0.05'],     // Max 5% HTTP errors allowed
        http_req_duration: ['p(95)<2000'], // 95% requests under 2000ms
    },
};

// Target Base URL (Default to local serve or environment variable)
const BASE_URL = __ENV.TARGET_URL || 'http://127.0.0.1:8000';

export default function () {
    // 1. Homepage
    const resHome = http.get(`${BASE_URL}/`);
    check(resHome, {
        'Homepage status 200': (r) => r.status === 200,
    });

    sleep(1);

    // 2. Articles Index
    const resArticles = http.get(`${BASE_URL}/blog`);
    check(resArticles, {
        'Blog status 200': (r) => r.status === 200,
    });

    sleep(1);

    // 3. Career Center
    const resCareer = http.get(`${BASE_URL}/career`);
    check(resCareer, {
        'Career status 200': (r) => r.status === 200,
    });

    sleep(1);
}
