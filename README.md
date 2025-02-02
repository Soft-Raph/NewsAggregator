# News Aggregator

Welcome to the **News Aggregator**! This is a platform designed to fetch, process, and display news articles from multiple sources. It supports fetching articles from various news APIs and stores them in a database for later use. It can be extended to provide a customizable interface for displaying the news.

## Features

- **API Integration**: Fetches the latest news articles from various news APIs.
- **Automatic Updates**: News articles are fetched and stored regularly (every minute).
- **Article Storage**: Articles are stored in a database with relevant metadata.
- **Search & Filter**: Search for articles based on keywords and filter by source, date or category.

## Installation

### Prerequisites

Ensure you have the following installed:

- **PHP** >= 8.x
- **Composer** (for PHP package management)
- **MySQL**
- **Laravel 11** (This project is built using Laravel 11)
- **News API keys** (depending on which news APIs you integrate with)


**Command**: Use the `php artisan articles:fetch` command to fetch and store news articles from the integrated news APIs into the database.

### How It Works
1. The command triggers a queued job called `FetchArticlesJob`.
2. The job iterates through the configured news API integrations and retrieves their latest articles.
3. Articles are then stored in the database, ensuring no duplicate entries.
4. There are three News Api integrated and you can always add more easily

These are the .env variable to supply their respective keys 
- **NEWSAPI_KEY=**
- **GUARDIAN_API_KEY=**
- **NYTIMES_API_KEY=**

![img.png](img.png)

Clone the repository to your local machine:

```bash
git clone https://github.com/yourusername/news-aggregator.git
cd news-aggregator
composer install
php artisan migrate
