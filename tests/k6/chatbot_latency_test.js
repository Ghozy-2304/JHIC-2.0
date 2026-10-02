import http from 'k6/http';
import { check, sleep } from 'k6';
import { Trend } from 'k6/metrics';

/**
 * k6 Chatbot Latency & Response Speed Benchmark Script
 * 
 * Objective: Measure exact AI response time (latency) in seconds for single-user interactions.
 */

// Custom metrics to track response speeds
const sessionInitLatency = new Trend('ai_session_init_time_ms');
const chatResponseLatency = new Trend('ai_chat_response_time_ms');

export const options = {
    vus: 1,                 // 1 Single user to test pure response speed without load noise
    iterations: 5,          // Run 5 sequential prompts to calculate accurate average speed
    thresholds: {
        ai_chat_response_time_ms: ['p(95)<12000'], // 95% of full LLM RAG responses finish within 12 seconds
        http_req_failed: ['rate<0.01'],            // 0% errors expected
    },
};

const TARGET_URL = __ENV.TARGET_URL || 'https://idnbs.my.id';
const IS_DIRECT = __ENV.DIRECT_FASTAPI === 'true';
const API_KEY = __ENV.FASTAPI_API_KEY || 'fastapichatbotbackend@2026';

const PROMPTS = [
    'Halo, sapa saya dengan ramah dan sebutkan namamu!',
    'Sebutkan jurusan unggulan di SMK IDN Boarding School!',
    'Bagaimana cara mendaftar sebagai santri baru di IDN Boarding School?',
    'Apa saja fasilitas pendukung yang tersedia untuk siswa?',
    'Terima kasih atas informasinya!'
];

export default function (data) {
    let convId = null;

    if (IS_DIRECT) {
        // Direct FastAPI Backend Test
        const initStart = Date.now();
        const initRes = http.post(`${TARGET_URL}/api/v1/conversations`, null, {
            headers: {
                'X-API-Key': API_KEY,
                'Content-Type': 'application/json',
            }
        });
        sessionInitLatency.add(Date.now() - initStart);

        if (initRes.status === 200 || initRes.status === 201) {
            try {
                convId = JSON.parse(initRes.body).conversation_id;
            } catch (e) {}
        }

        // Test each prompt sequentially
        for (let i = 0; i < PROMPTS.length; i++) {
            const prompt = PROMPTS[i];
            const chatPayload = JSON.stringify({
                message: prompt,
                conversation_id: convId
            });

            const chatStart = Date.now();
            const chatRes = http.post(`${TARGET_URL}/api/v1/chat`, chatPayload, {
                headers: {
                    'X-API-Key': API_KEY,
                    'Content-Type': 'application/json',
                },
                timeout: '60s'
            });
            const duration = Date.now() - chatStart;
            chatResponseLatency.add(duration);

            check(chatRes, {
                'AI Responded Successfully (200/201)': (r) => r.status === 200 || r.status === 201,
            });

            console.log(`[Prompt ${i + 1}] Respon AI diterima dalam ${(duration / 1000).toFixed(2)} detik`);

            sleep(2); // Short pause between prompts
        }

    } else {
        // End-to-End Laravel Proxy Test
        const initStart = Date.now();
        const initRes = http.post(`${TARGET_URL}/api/chatbot/conversations`, null, {
            headers: { 'Content-Type': 'application/json' }
        });
        sessionInitLatency.add(Date.now() - initStart);

        if (initRes.status === 200 || initRes.status === 201) {
            try {
                convId = JSON.parse(initRes.body).conversation_id;
            } catch (e) {}
        }

        for (let i = 0; i < PROMPTS.length; i++) {
            const prompt = PROMPTS[i];
            const chatPayload = JSON.stringify({
                message: prompt,
                conversation_id: convId
            });

            const chatStart = Date.now();
            const chatRes = http.post(`${TARGET_URL}/api/chatbot/chat`, chatPayload, {
                headers: { 'Content-Type': 'application/json' },
                timeout: '60s'
            });
            const duration = Date.now() - chatStart;
            chatResponseLatency.add(duration);

            check(chatRes, {
                'AI Responded Successfully (200/201)': (r) => r.status === 200 || r.status === 201,
            });

            console.log(`[Prompt ${i + 1}] Respon AI diterima dalam ${(duration / 1000).toFixed(2)} detik`);

            sleep(2);
        }
    }
}
