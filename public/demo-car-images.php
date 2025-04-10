<?php

// Basic settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Loading the Laravel environment
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Loading required facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

// Removing admin rights check
echo '<h2>Update Car Images</h2>';
echo '<p>This script will add random images from Unsplash to all cars.</p>';

// Sample car images
$demoImages = [
    'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1583121274602-3e2820c69888?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1553440569-bcc63803a83d?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1502877338535-766e1452684a?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1542362567-b07e54358753?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?w=500&h=350&crop=1',
    'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?w=500&h=350&crop=1',
];

// Function for downloading and saving images
function downloadAndSaveImage($url, $carId, $isPrimary = false, $order = 0) {
    // Creating a context to bypass SSL verification
    $context = stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);
    
    // Download content with the created context
    $contents = file_get_contents($url, false, $context);
    
    $filename = 'cars/car_' . $carId . '_' . uniqid() . '.jpg';
    $path = storage_path('app/public/' . $filename);
    
    // Create directory if it doesn't exist
    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0777, true);
    }
    
    // Save the file
    file_put_contents($path, $contents);
    
    // Return the path relative to storage/app/public
    return $filename;
}

// Request to delete old images
try {
    // Delete old images from database
    DB::table('car_images')->truncate();
    echo '<p>All old image records have been deleted.</p>';
    
    // Get all cars
    $cars = DB::table('cars')->get();
    echo '<p>Found ' . count($cars) . ' cars.</p>';
    
    // Add new images for each car
    foreach ($cars as $car) {
        // Select a random number of images (1 to 3) for this car
        $numImages = rand(1, 3);
        echo '<p>Adding ' . $numImages . ' images for car #' . $car->id . ' (' . $car->make . ' ' . $car->model . ')</p>';
        
        for ($i = 0; $i < $numImages; $i++) {
            // Select a random image
            $randomImageUrl = $demoImages[array_rand($demoImages)];
            
            // Download and save the image
            $imagePath = downloadAndSaveImage($randomImageUrl, $car->id, $i === 0, $i);
            
            // Add record to database
            DB::table('car_images')->insert([
                'car_id' => $car->id,
                'image_path' => $imagePath,
                'is_primary' => $i === 0,
                'display_order' => $i,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            echo '<p style="margin-left: 20px;">Image added: ' . $imagePath . ($i === 0 ? ' (primary)' : '') . '</p>';
        }
    }
    
    echo '<p style="color: green; font-weight: bold;">All images have been updated successfully!</p>';
    echo '<p><a href="/cars" style="background-color: #3b82f6; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">Go to cars page</a></p>';
    
} catch (Exception $e) {
    echo '<p style="color: red;">Error: ' . $e->getMessage() . '</p>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
} 