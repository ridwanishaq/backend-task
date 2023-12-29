# Konvey Backend - Take Home Assessment

## Installation in local environment using Docker
1. Clone the <b>repo</b>
2. Navigate to the `/app`, the root of Laravel dir and type `cp .env.example .env`
3. Configure the `.env` file by providing the AI API KEYS, 
    - Google Gemini AI - `GEMINI_AI_API_KEY=`
    - Stable Diffusion AI - `STABILITY_AI_API_KEY=`
4. Navigate to root directory and run the following commands:
    - Build the images by running: `docker-compose build`
    - Start the containers: `docker-compose up -d`
5. 
6. 

## Screenshorts:
> This is the full example of prompt (Text & Image) both of which generate from Google Gemini AI & Stable Diffusion:
- ![A short story of northan Nigeria.](https://raw.githubusercontent.com/ridwanishaq/backend-task/master/app/public/assets/images/a-short-story-of-north.png)

> This the serialized output from Gemini AI (before implementing the Stable Diffusion):
- ![A short history of computer.](https://raw.githubusercontent.com/ridwanishaq/backend-task/master/app/public/assets/images/a-short-history-of-computer.png)

