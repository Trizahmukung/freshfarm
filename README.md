 FreshFarm - Farm-to-Consumer Platform

<p>This repository contains a complete Farm-to-Consumer platform built with Laravel and Vue.js. It's designed to connect farmers directly with consumers, eliminating middlemen and ensuring fresh produce delivery with optimized logistics.</p>

<h2>Core Setup</h2>
<ul>
    <li><strong>Laravel Version</strong>: 10.x</li>
    <li><strong>Vue.js</strong>: 2.7.x</li>
    <li><strong>Database</strong>: MySQL/PostgreSQL</li>
</ul>

<h2>3rd Party Plugins</h2>
<ul>
    <li>Spatie Laravel-Permissions - Role-based access control</li>
    <li>Laravel Sanctum - API authentication</li>
    <li>Google Maps APIs - Location and delivery optimization</li>
    <li>FontAwesome Free Icons - UI icons</li>
</ul>

<h2>Installation Instructions</h2>

<ol>
    <li><strong>Clone this repository</strong><br>
        <code>git clone https://github.com/yourusername/freshfarm.git<br>
        cd freshfarm</code>
    </li>
    
    <li><strong>Change Git Origin</strong> (Important: Push requests to this original repo will not be accepted)<br>
        <code>git remote set-url origin &lt;your_new_repository_url&gt;</code><br>
        Example:<br>
        <code>git remote set-url origin https://github.com/your-username/your-freshfarm-repo.git</code>
    </li>

    <li><strong>Verify remote URL</strong><br>
        <code>git remote -v</code>
    </li>

    <li><strong>Install PHP dependencies</strong><br>
        <code>composer install</code>
    </li>

    <li><strong>Install JavaScript dependencies</strong><br>
        <code>npm install</code>
    </li>

    <li><strong>Environment setup</strong><br>
        <code>cp .env.example .env<br>
        php artisan key:generate</code><br>
        Configure your database settings and Google Maps API key in <code>.env</code> file
    </li>

    <li><strong>Database setup</strong><br>
        <code>php artisan migrate<br>
        php artisan db:seed --class=PermissionSeeder</code>
    </li>

    <li><strong>Build assets for development</strong><br>
        <code>npm run dev</code>
    </li>

    <li><strong>Start development server</strong><br>
        <code>php artisan serve</code>
    </li>
</ol>

<h2>Default Features Included</h2>
<ul>
    <li>User authentication with role management (Admin, Farmer, Consumer, Driver)</li>
    <li>Farm and product management system</li>
    <li>Order processing with delivery optimization</li>
    <li>Permission-based access control</li>
    <li>Review and rating system</li>
    <li>Responsive sidebar navigation with FontAwesome icons</li>
</ul>

<h2>Project Structure</h2>
<p>The repository includes default models, controllers, routes, and views as prototypes for rapid development of farm-to-consumer SPA applications.</p>

<h2>Maintenance</h2>
<p>This project shall be maintained regularly by the development team and shall be used to initiate new farm-to-consumer platform projects.</p>

<hr>

<p><strong>Note</strong>: Remember to configure your Google Maps API keys and database credentials before deployment. Ensure all environment variables are properly set in your <code>.env</code> file.</p>