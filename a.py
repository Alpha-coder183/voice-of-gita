import requests

API_URL = "https://router.huggingface.co/novita/v3/openai/chat/completions"
headers = {"Authorization": "Bearer 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"}

def query(payload):
    response = requests.post(API_URL, headers=headers, json=payload)
    return response.json()

response = query({
    "messages": [
        {
            "role": "user",
            "content": "What is the capital of France?"
        }
    ],
    "max_tokens": 500,
    "model": "deepseek/deepseek-v3-0324"
})

print(response["choices"][0]["message"])