# Development Documentation

## Project Overview

**Project Name:** Fixithub  
**Description:** Fixithub is a Crowdsourcing System designed to connect the public, crowdworkers, and the government to collaboratively address issues. The application allows the public to report problems, crowdworkers to provide solutions, and the government to manage verification and solution implementation. With this application, it is expected to foster more effective and transparent collaboration in solving various social issues.

**Tech Stack:**

-   **Framework:** Laravel
-   **Frontend:** Tailwind CSS
-   **Database:** Backendless
-   **Other Tools/Libraries:**
    -   TinyMCE (Text Editor)
    -   Cloudinary (Media File Storage)

**Repository Link:** [Fixithub Repository](https://github.com/Abdi-01/fixithub.git)

---

## Development Environment Setup

### Prerequisites

Ensure the following tools are installed:

1. **PHP**: Version 8.2.\* (or adjust to match your project version).
2. **Composer**: Latest version.
3. **Node.js & npm**: [Version used during development, e.g., Node.js 18+].
4. **Database**: Backendless.
5. **Git**: [Version used, e.g., 2.40+].

### Installation Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/Abdi-01/fixithub.git
    cd fixithub
    ```
2. Install PHP dependencies:
    ```bash
    composer install
    ```
3. Install JavaScript dependencies:
    ```bash
    npm install
    ```
4. Set up environment variables:
    - Duplicate the `.env.example` file and rename it to `.env`.
    - Update database and application settings in the `.env` file.
5. Generate application key:
    ```bash
    php artisan key:generate
    ```
6. Run database migrations and seeders (if applicable):
    ```bash
    php artisan migrate --seed
    ```
7. Start Vite for frontend assets:
    ```bash
    npm run dev
    ```
    - This will enable auto-restart when there are changes, especially for Tailwind CSS styling.
8. Start the development server:
    ```bash
    php artisan serve
    ```

---

## Folder Structure Overview

-   **/app**: Contains application logic (Models, Controllers, etc.).
-   **/config**: Configuration files for the application.
-   **/resources**: Frontend assets and views.
-   **/routes**: Application routes (web, API, etc.).
-   **/database**: Migrations, seeders, and factories.
-   **/public**: Publicly accessible files (e.g., images, compiled assets).

---

## Key Features and Functionalities

### Feature 1: Problem Reporting

**Description:** Allows users to report issues with detailed descriptions and media uploads.

-   Files/Components Involved: [List relevant files]
-   Key Routes: [List key routes for this feature]
-   Configuration/Environment Variables: [Any related .env variables]

### Feature 2: Crowdworker Solutions

**Description:** Enables crowdworkers to view, discuss, and propose solutions to reported issues.

-   Files/Components Involved: [List relevant files]
-   Key Routes: [List key routes for this feature]
-   Configuration/Environment Variables: [Any related .env variables]

### Feature 3: Government Management

**Description:** Provides tools for the government to verify and implement solutions, ensuring transparency.

-   Files/Components Involved: [List relevant files]
-   Key Routes: [List key routes for this feature]
-   Configuration/Environment Variables: [Any related .env variables]

---

## Deployment Instructions

### Deploying to Vercel

#### Method 1: Connect GitHub Repository

1. Log in to your [Vercel](https://vercel.com/) account.
2. Click on **Add New Project**.
3. Select **Import Git Repository** and connect your GitHub account.
4. Locate and select the Fixithub repository.
5. Configure the project:
    - **Build Command:** `npm run build`
    - **Output Directory:** `public`
    - Add the required environment variables from your `.env` file.
6. Click **Deploy**.
7. After deployment, Vercel will provide a live URL for your project.

#### Method 2: Manual Upload

1. Run the following commands locally to prepare the build:
    ```bash
    npm run build
    ```
2. Compress the entire project directory (excluding `node_modules` and `.env` for security).
3. Log in to your [Vercel](https://vercel.com/) account.
4. Click on **Add New Project** > **Manual Deployment**.
5. Upload the compressed file and configure:
    - **Build Command:** `npm run build`
    - **Output Directory:** `public`
    - Add the required environment variables from your `.env` file.
6. Click **Deploy**.
7. Once the deployment is complete, Vercel will provide the project URL.

#### Method 3: Using Vercel CLI

1. Install Vercel CLI globally on your machine:
    ```bash
    npm install -g vercel
    ```
2. Navigate to your project directory:
    ```bash
    cd fixithub
    ```
3. Run the following command to deploy:
    ```bash
    vercel
    ```
4. Follow the CLI prompts:
    - Select the project scope.
    - Define the output directory as `public/build`.
    - Set up the environment variables when prompted.
5. Once the deployment is complete, Vercel will provide the live URL for your project.
6. For subsequent deployments, simply run:
    ```bash
    vercel --prod
    ```
    - This will deploy your project to production directly.

### Notes for Vercel Deployment

-   **Output Directory:** Ensure the output directory is set to `public/build` as shown in the Vercel Project Settings.
    ![gambar](https://github.com/user-attachments/assets/faa0c56f-d044-4791-934f-86478448e755)
-   **Node.js Version:** Set the Node.js version to 18.xx in Vercel for compatibility.
    ![gambar](https://github.com/user-attachments/assets/70b84f75-538b-4aa8-ad09-a143924a9bf5)
-   **Add this environtment variable** Set the environtment variables like this
    <img width="914" alt="Screenshot 2025-01-24 at 14 43 03" src="https://github.com/user-attachments/assets/12ec2ba2-39b7-43c5-818b-37008b2764b1" />


---

### Prerequisites for Server

Ensure the server meets these requirements:

1. **PHP**: Version 8.2.\* (or match project version).
2. **Web Server**: Nginx/Apache.
3. **Database**: Backendless.
4. **Node.js & npm**: [Version used during development].

### General Steps

1. Upload the project files to the server.
2. Set correct permissions for the `storage` and `bootstrap/cache` folders.
    ```bash
    chmod -R 775 storage bootstrap/cache
    ```
3. Install dependencies and compile assets:
    ```bash
    composer install --optimize-autoloader --no-dev
    npm run build
    ```
4. Configure the `.env` file with production settings.
5. Run database migrations:
    ```bash
    php artisan migrate --force
    ```
6. Clear and cache configurations:
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```
7. Restart the web server if needed.

---

## Maintenance Guide

### Common Commands

-   Clear application cache:
    ```bash
    php artisan cache:clear
    ```
-   View application logs:
    ```bash
    tail -f storage/logs/laravel.log
    ```
-   Run queued jobs:
    ```bash
    php artisan queue:work
    ```

### Adding New Features

1. Create a new branch for the feature:
    ```bash
    git checkout -b feature/[feature-name]
    ```
2. Follow the existing folder and coding conventions.
3. Before pushing changes related to Tailwind CSS styles, run:
    ```bash
    npm run build
    ```
4. Add and commit changes:
    ```bash
    git add .
    git commit -m "[Description of changes]"
    git push
    ```

---

## Additional Notes

-   **Documentation:** Refer to the `README.md` file for a quick project summary.
-   **Testing:** [Add notes on how to run tests if applicable, e.g., PHPUnit commands.]
-   **Support:** [Include contact info or further resources for client support.]

---

_Feel free to update this document as needed during further development._
