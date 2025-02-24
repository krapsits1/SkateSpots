# SkateSpots.eu

Welcome to **SkateSpots.eu**, the ultimate platform for skaters to discover, share, and review skate spots across Europe! Whether you're looking for a skatepark, a street spot, or a skate shop, SkateSpots.eu is here to help you explore and connect with the skateboarding community.

Visit the website: [SkateSpots.eu](https://skatesspots.eu)

## Features

### 🌍 Discover Skate Spots
- Explore a variety of skate spots on an interactive custom Google Map.
- Browse through categorized listings of skateparks, street spots, and skate shops.

### 🛹 Share Your Favorites
- Add new spots to the platform to help other skaters discover your favorite locations.
- Include details like photos, descriptions, and exact locations.

### ⭐ Review and Rate
- Leave reviews and ratings for skateparks to share your experience with others.
- Help skaters make informed decisions about where to skate next.

### 🔒 User Authentication
- Secure and seamless user authentication using Google.
- Create an account or log in with your Google credentials.

## Tech Stack

### 🖥️ Frontend & Backend
- **Laravel Framework**: The robust PHP framework powers the backend of SkateSpots.eu, ensuring scalability and reliability.

### 📍 Mapping
- **Custom Google Map Integration**: Our platform uses Google Maps API to provide a highly interactive and user-friendly map interface for discovering skate spots.

### 🔐 Authentication
- **Google Authentication**: Users can quickly sign up and log in using their Google accounts.

## Getting Started

Follow these steps to set up SkateSpots.eu on your local machine:

### Prerequisites
1. Ensure you have the following installed on your system:
   - PHP 8.0+
   - Composer
   - Node.js & npm
   - A web server (e.g., Apache, Nginx)
   - MySQL or other supported database

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/your-repo/skatesspots-eu.git
   cd skatesspots-eu
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up environment variables:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update `.env` with your database, Google Maps API key, and Google OAuth credentials.

4. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

5. Serve the application:
   ```bash
   php artisan serve
   ```

6. Compile frontend assets:
   ```bash
   npm run dev
   ```

### Access the Website
Once the server is running, open your browser and navigate to `http://localhost:8000` to access SkateSpots.eu locally.

## Adding Images

To add an image to this README, include it in your repository (e.g., `public/images/about/Untitled design.png`) and reference it like this:

```markdown
<p align="center">
  <img src="public/images/about/Untitled design.png" alt="About Image" width="300">
</p>
```

## Contribution

We welcome contributions from the community! If you'd like to help improve SkateSpots.eu:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Commit your changes and push the branch.
4. Submit a pull request.

Please ensure your code adheres to the [Laravel coding standards](https://laravel.com/docs/).

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

Thank you for being a part of SkateSpots.eu! Together, let's make the skateboarding community stronger and more connected. 🛹✨
