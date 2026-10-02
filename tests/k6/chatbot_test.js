import http from 'k6/http';
import { check, sleep } from 'k6';

/**
 * k6 Chatbot Performance & Load Test Script for JHIC Application
 * 
 * Objectives:
 * 1. Test Chatbot AI response latency under concurrent user load.
 * 2. Verify response times under 3000ms (3 seconds).
 * 3. Verify HTTP 200 status and non-empty AI answer.
 * 
 * Usage:
 * - Test via VPS Laravel Proxy (Recommended End-to-End User Experience):
 *   k6 run -e TARGET_URL=https://idnbs.my.id tests/k6/chatbot_test.js
 * 
 * - Test Direct FastAPI Local Backend on VPS:
 *   k6 run -e TARGET_URL=http://127.0.0.1:8000 -e DIRECT_FASTAPI=true tests/k6/chatbot_test.js
 */

export const options = {
    stages: [
        { duration: '10s', target: 5 },   // Warm-up to 5 VUs
        { duration: '30s', target: 15 },  // Hold 15 concurrent Chatbot VUs
        { duration: '10s', target: 0 },   // Ramp-down
    ],
    thresholds: {
        http_req_failed: ['rate<0.05'],     // Max 5% HTTP errors allowed
        http_req_duration: ['p(90)<3000'], // 90% requests under 3000ms
    },
};

const TARGET_URL = __ENV.TARGET_URL || 'https://idnbs.my.id';
const IS_DIRECT = __ENV.DIRECT_FASTAPI === 'true';
const API_KEY = __ENV.FASTAPI_API_KEY || 'fastapichatbotbackend@2026';

export default function () {
    let url, payload, headers;

    if (IS_DIRECT) {
        // Direct FastAPI Backend Endpoint on VPS
        url = `${TARGET_URL}/api/v1/chat`;
        payload = JSON.stringify({
            message: 'Halo, sebutkan jurusan apa saja yang ada di SMK IDN Boarding School?',
        });
        headers = {
            'Content-Type': 'application/json',
            'X-API-Key': API_KEY,
        };
    } else {
        // End-to-End Laravel Proxy Endpoint (Real User Experience)
        url = `${TARGET_URL}/api/chatbot/chat`;
        payload = JSON.stringify({
            message: 'Halo, sebutkan jurusan apa saja yang ada di SMK IDN Boarding School?',
        });
        headers = {
            'Content-Type': 'application/json',
        };
    }

    const res = http.post(url, payload, { headers: headers });

    check(res, {
        'Chatbot status 200': (r) => r.status === 200,
        'Response time < 3000ms': (r) => r.timings.duration < 3000,
        'Has response body': (r) => r.body && r.body.length > 0,
    });

    sleep(1);
}
