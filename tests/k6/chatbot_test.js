import http from 'k6/http';
import { check, sleep } from 'k6';

/**
 * k6 Chatbot Performance & Latency Test Script for JHIC Application
 * 
 * Objectives:
 * 1. Warmup and create conversation session via /api/chatbot/conversations.
 * 2. Send AI chat message via /api/chatbot/chat.
 * 3. Verify response times under 3000ms.
 */

export const options = {
    stages: [
        { duration: '10s', target: 5 },   // Warm-up to 5 VUs
        { duration: '30s', target: 15 },  // Hold 15 concurrent Chatbot VUs
        { duration: '10s', target: 0 },   // Ramp-down
    ],
    thresholds: {
        http_req_failed: ['rate<0.10'],     // Target < 10% errors
        http_req_duration: ['p(90)<3000'], // 90% requests under 3000ms
    },
};

const TARGET_URL = __ENV.TARGET_URL || 'https://idnbs.my.id';
const IS_DIRECT = __ENV.DIRECT_FASTAPI === 'true';
const API_KEY = __ENV.FASTAPI_API_KEY || 'fastapichatbotbackend@2026';

export default function () {
    let convId = null;

    if (IS_DIRECT) {
        // Direct FastAPI Backend Local Test on VPS
        const initUrl = `${TARGET_URL}/api/v1/conversations`;
        const initRes = http.post(initUrl, null, {
            headers: {
                'X-API-Key': API_KEY,
                'Content-Type': 'application/json',
            }
        });

        if (initRes.status === 200 || initRes.status === 201) {
            try {
                const body = JSON.parse(initRes.body);
                convId = body.conversation_id;
            } catch (e) {}
        }

        const chatUrl = `${TARGET_URL}/api/v1/chat`;
        const payload = JSON.stringify({
            message: 'Halo, sebutkan jurusan apa saja yang ada di SMK IDN Boarding School?',
            conversation_id: convId,
        });

        const chatRes = http.post(chatUrl, payload, {
            headers: {
                'X-API-Key': API_KEY,
                'Content-Type': 'application/json',
            }
        });

        check(chatRes, {
            'Direct FastAPI status is 200/201': (r) => r.status === 200 || r.status === 201,
            'Response time < 3000ms': (r) => r.timings.duration < 3000,
        });

    } else {
        // End-to-End Laravel Proxy Test
        const initUrl = `${TARGET_URL}/api/chatbot/conversations`;
        const initRes = http.post(initUrl, null, {
            headers: { 'Content-Type': 'application/json' }
        });

        check(initRes, {
            'Session Init status 200/201': (r) => r.status === 200 || r.status === 201,
        });

        if (initRes.status === 200 || initRes.status === 201) {
            try {
                const body = JSON.parse(initRes.body);
                convId = body.conversation_id;
            } catch (e) {}
        }

        const chatUrl = `${TARGET_URL}/api/chatbot/chat`;
        const payload = JSON.stringify({
            message: 'Halo, sebutkan jurusan apa saja yang ada di SMK IDN Boarding School?',
            conversation_id: convId,
        });

        const chatRes = http.post(chatUrl, payload, {
            headers: { 'Content-Type': 'application/json' }
        });

        check(chatRes, {
            'Chatbot status 200/201': (r) => r.status === 200 || r.status === 201,
            'Response time < 3000ms': (r) => r.timings.duration < 3000,
        });
    }

    sleep(1);
}
