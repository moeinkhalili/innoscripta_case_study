# Articles Case Study Project

This is a case study project that fetches news from multiple data sources and displays them to users. The project is built with **Laravel** and is designed to run using **Docker** for easy setup and deployment.

## Features
- Fetch news from multiple APIs:
    - [The Guardian API](https://open-platform.theguardian.com/)
    - [NewsAPI](https://newsapi.org/)
    - [New York Times API](https://developer.nytimes.com/)
- Store fetched articles in a database
- Display articles to users
- Easily testable via Laravel’s testing suite

## Requirements
- Docker
- Docker Compose
- API keys for the following services:
    - `GUARDIAN_API_KEY`
    - `NEWSAPI_API_KEY`
    - `NEWYORK_TIMES_API_KEY`

## Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd <project-folder>
```

2. **Create the environment file**
```bash
cp .env.example .env
```

3. **Fill in your API keys** in `.env`
```env
GUARDIAN_API_KEY=""
NEWSAPI_API_KEY=""
NEWYORK_TIMES_API_KEY=""
```

4. **Start the Docker containers**
```bash
docker compose up -d
```

5. **Set up Laravel**
```bash
docker compose exec -it laravel.test php artisan key:generate
docker compose exec -it laravel.test composer install
docker compose exec -it laravel.test php artisan migrate
```

6. **Fetch articles manually (A cron should run this)**
```bash
docker compose exec -it laravel.test php artisan app:fetch-articles
```

## Running Tests
```bash
docker compose exec -it laravel.test php artisan test
```

## Notes
- Make sure your API keys are valid and have enough quota.
- Docker ensures a consistent environment, so the project should work the same across different machines.
