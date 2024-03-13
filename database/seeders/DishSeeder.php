<?php

namespace Database\Seeders;

use App\Models\Dish;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dish::insert([
            [
                'menu_id' => 1,
                'type_id' => 1,
                'name' => 'Chinese Fried Rice',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 500
            ],
            [
                'menu_id' => 1,
                'type_id' => 1,
                'name' => 'Garlic Rice',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 500
            ],
            [
                'menu_id' => 1,
                'type_id' => 1,
                'name' => 'Plain Steamed Rice',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 500
            ],
            //  chicken
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Buffalo Chicken Wing',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Chicken Adobo',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Chicken Afritada',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Chicken ala King',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Chicken Barbeque',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Chicken Cordon Bleu',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Chicken Lolipop',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Chicken Teriyaki',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'General Tso Chicken',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Italian Chicken Parmigiana',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Korean Fried Chicken',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Orange Chicken',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 2,
                'type_id' => 2,
                'name' => 'Pandan Chicken',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            //  beef
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Bulgogi',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Calderita',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Callos',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Kare-kare',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Mechado',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Salpicao',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Shepherd Pie',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Tapa',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Teriyaki',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Beef Broccoli/Mushroom',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 3,
                'type_id' => 2,
                'name' => 'Steak and Potatoe',
                'description' => 'test1',
                'price_full' => 4500,
                'price_half' => 0
            ],
            //  pork
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Baby Back Ribs',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Callos ala Madrilena',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Fried Cholitas',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Lechon Kawali',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Lumpiang Shanghai',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Peach Glazed Ham',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Pork Hamonada',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Pork Humba',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Pork Sinugba',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Pork Sweet and Sour',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Pork Tocino',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Pork with Mushroom',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 4,
                'type_id' => 2,
                'name' => 'Milk Braised Pork',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            //  fish and seafoods
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Filipino Escabeche',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Fish Fillet w/ Garlic Aioli',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Fish Fillet w/ Sweet Chili',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Fish Piccata',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Fish Sweet and Sour',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Fish Tausi',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Fish Beurre Bianc',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Salmon',
                'description' => 'test1',
                'price_full' => 2200,
                'price_half' => 0
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Kinilaw',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Seafood Curry',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Vietnamese Fish',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Salted Egg Shrimp',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            [
                'menu_id' => 5,
                'type_id' => 2,
                'name' => 'Shrimp Thermidor',
                'description' => 'test1',
                'price_full' => 1970,
                'price_half' => 1000
            ],
            //  pasta, noodles and salads
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Bam-i',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Bihon',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Chicken Carbonara',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Chicken Piccata Pasta',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Filipino Style Spaghetti',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Fresh Tomato Pasta',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Italian Style Spaghetti',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Lasagna',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Pancit Canton Guisado',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Pasta Puttanesca',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Penne Bolognese',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Penne Buranella',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Sotanghon Guisado',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Summer Truffle Pasta',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Potato Salad',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Tuna Carbonara',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Waldorf Salad',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            [
                'menu_id' => 6,
                'type_id' => 3,
                'name' => 'Macaroni Salad',
                'description' => 'test1',
                'price_full' => 1770,
                'price_half' => 900
            ],
            //  vegetable
            [
                'menu_id' => 7,
                'type_id' => 4,
                'name' => 'Buttered Vegetables',
                'description' => 'test1',
                'price_full' => 1470,
                'price_half' => 750
            ],
            [
                'menu_id' => 7,
                'type_id' => 4,
                'name' => 'Chopseuy',
                'description' => 'test1',
                'price_full' => 1470,
                'price_half' => 750
            ],
            [
                'menu_id' => 7,
                'type_id' => 4,
                'name' => 'Mixed Greens in Lemon Vinaigrette',
                'description' => 'test1',
                'price_full' => 1470,
                'price_half' => 750
            ],
            [
                'menu_id' => 7,
                'type_id' => 4,
                'name' => 'Mixed Greens in Thousand Island Dressing',
                'description' => 'test1',
                'price_full' => 1470,
                'price_half' => 750
            ],
            [
                'menu_id' => 7,
                'type_id' => 4,
                'name' => 'Vegetable Lumpia',
                'description' => 'test1',
                'price_full' => 1470,
                'price_half' => 750
            ],
            //  dessert
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Apple Cobbler',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Black Sambo Mousse',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Blueberry Cobbler',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Buko-Lychee Salad',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Buko-Pandan Salad',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Caramel Cake',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Carrot Cake',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Chocolate Cake',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Cream Puffs',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Fiesta Fruit Salad',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Fresh Fruits in Honey Calamansi Syrup',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Icebox Cake',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Leche Flan',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Lemon Cheesecake',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Maja Blanca',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Mango Float',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Mango Sago',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
            [
                'menu_id' => 9,
                'type_id' => 6,
                'name' => 'Fresh Fruits',
                'description' => 'test1',
                'price_full' => 970,
                'price_half' => 650
            ],
        ]);
    }
}
