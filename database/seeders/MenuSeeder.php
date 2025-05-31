<?php

    namespace Database\Seeders;

    use App\Models\Menu;
    use App\Models\MenuItem;
    use Illuminate\Database\Seeder;

    class MenuSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            // Filipino cuisine menus
            $this->createMenu(
                'Filipino Fiesta',
                'Traditional Filipino dishes perfect for celebrations',
                [
                    ['name' => 'Lechon Kawali', 'description' => 'Crispy deep-fried pork belly', 'price' => 280.00],
                    ['name' => 'Chicken Adobo', 'description' => 'Chicken marinated in soy sauce, vinegar and spices', 'price' => 220.00],
                    ['name' => 'Pancit Canton', 'description' => 'Stir-fried noodles with vegetables and meat', 'price' => 180.00],
                    ['name' => 'Lumpiang Shanghai', 'description' => 'Filipino spring rolls with ground pork filling', 'price' => 150.00],
                    ['name' => 'Sinigang na Baboy', 'description' => 'Pork in sour tamarind soup with vegetables', 'price' => 250.00],
                    ['name' => 'Biko', 'description' => 'Sweet sticky rice cake with caramelized coconut topping', 'price' => 120.00],
                ]
            );

            $this->createMenu(
                'Filipino Seafood Feast',
                'Fresh seafood prepared in traditional Filipino style',
                [
                    ['name' => 'Sinigang na Hipon', 'description' => 'Shrimp in tamarind soup with vegetables', 'price' => 320.00],
                    ['name' => 'Inihaw na Pusit', 'description' => 'Grilled squid with calamansi and soy dipping sauce', 'price' => 280.00],
                    ['name' => 'Kilawing Tanigue', 'description' => 'Fresh fish ceviche with vinegar, calamansi, and spices', 'price' => 250.00],
                    ['name' => 'Ginataang Alimasag', 'description' => 'Crabs cooked in coconut milk and spices', 'price' => 350.00],
                    ['name' => 'Binukadkad na Tilapia', 'description' => 'Deep-fried butterflied tilapia', 'price' => 230.00],
                    ['name' => 'Ginataang Bilo-Bilo', 'description' => 'Sweet coconut soup with glutinous rice balls and fruits', 'price' => 140.00],
                ]
            );

            // International cuisine menus
            $this->createMenu(
                'Western Classics',
                'Popular Western dishes for any occasion',
                [
                    ['name' => 'Roast Beef with Gravy', 'description' => 'Slow-roasted beef with rich brown gravy', 'price' => 380.00],
                    ['name' => 'Grilled Salmon', 'description' => 'Fresh salmon with lemon butter sauce', 'price' => 350.00],
                    ['name' => 'Chicken Cordon Bleu', 'description' => 'Breaded chicken stuffed with ham and cheese', 'price' => 320.00],
                    ['name' => 'Creamy Mashed Potatoes', 'description' => 'Smooth potatoes with butter and cream', 'price' => 120.00],
                    ['name' => 'Garden Salad', 'description' => 'Fresh mixed greens with balsamic dressing', 'price' => 150.00],
                    ['name' => 'New York Cheesecake', 'description' => 'Classic creamy cheesecake with berry compote', 'price' => 180.00],
                ]
            );

            $this->createMenu(
                'Italian Favorites',
                'Authentic Italian dishes made with premium ingredients',
                [
                    ['name' => 'Lasagna al Forno', 'description' => 'Layered pasta with meat sauce and cheese', 'price' => 280.00],
                    ['name' => 'Risotto ai Funghi', 'description' => 'Creamy risotto with wild mushrooms', 'price' => 260.00],
                    ['name' => 'Chicken Parmigiana', 'description' => 'Breaded chicken with tomato sauce and mozzarella', 'price' => 290.00],
                    ['name' => 'Penne Arrabiata', 'description' => 'Pasta with spicy tomato sauce', 'price' => 220.00],
                    ['name' => 'Caprese Salad', 'description' => 'Fresh tomatoes, mozzarella, and basil with olive oil', 'price' => 180.00],
                    ['name' => 'Tiramisu', 'description' => 'Coffee-flavored Italian dessert with mascarpone', 'price' => 190.00],
                ]
            );

            // Specialized event menus
            $this->createMenu(
                'Wedding Luxury',
                'Elegant dishes for wedding receptions and formal events',
                [
                    ['name' => 'Prime Rib Carving Station', 'description' => 'Slow-roasted prime rib served with au jus', 'price' => 450.00],
                    ['name' => 'Lobster Thermidor', 'description' => 'Lobster in creamy sauce, gratinéed with cheese', 'price' => 520.00],
                    ['name' => 'Duck Confit', 'description' => 'Slow-cooked duck leg with orange reduction', 'price' => 380.00],
                    ['name' => 'Truffle Risotto', 'description' => 'Creamy risotto with truffle oil and parmesan', 'price' => 320.00],
                    ['name' => 'Asparagus with Hollandaise', 'description' => 'Fresh asparagus with rich butter sauce', 'price' => 180.00],
                    ['name' => 'Wedding Cake', 'description' => 'Elegantly designed multi-tier cake', 'price' => 380.00],
                ]
            );

            $this->createMenu(
                'Corporate Lunch',
                'Professional catering options for business meetings and events',
                [
                    ['name' => 'Roast Beef Sandwich Platter', 'description' => 'Assorted gourmet sandwiches with premium fillings', 'price' => 220.00],
                    ['name' => 'Pasta Salad', 'description' => 'Pasta with mixed vegetables and Italian dressing', 'price' => 160.00],
                    ['name' => 'Chicken Wraps', 'description' => 'Grilled chicken wraps with fresh vegetables', 'price' => 190.00],
                    ['name' => 'Fresh Fruit Platter', 'description' => 'Assortment of seasonal fruits', 'price' => 180.00],
                    ['name' => 'Vegetable Crudité', 'description' => 'Fresh vegetable sticks with dips', 'price' => 150.00],
                    ['name' => 'Assorted Cookies', 'description' => 'Selection of freshly baked cookies', 'price' => 120.00],
                ]
            );

            // Dessert and drinks menus
            $this->createMenu(
                'Dessert Selection',
                'Sweet treats for any occasion',
                [
                    ['name' => 'Chocolate Fondue', 'description' => 'Warm chocolate dip with fruit and marshmallows', 'price' => 280.00],
                    ['name' => 'Leche Flan', 'description' => 'Filipino caramel custard', 'price' => 150.00],
                    ['name' => 'Mango Float', 'description' => 'Layered dessert with mangoes and cream', 'price' => 180.00],
                    ['name' => 'Assorted Cakes', 'description' => 'Selection of premium cake slices', 'price' => 220.00],
                    ['name' => 'Ice Cream Station', 'description' => 'Various ice cream flavors with toppings', 'price' => 250.00],
                    ['name' => 'Fruit Tarts', 'description' => 'Buttery tart shells with fresh fruits', 'price' => 160.00],
                ]
            );

            $this->createMenu(
                'Beverage Package',
                'Refreshing drinks for events and celebrations',
                [
                    ['name' => 'Fruit Juice Selection', 'description' => 'Assorted fresh fruit juices', 'price' => 150.00],
                    ['name' => 'Iced Tea Station', 'description' => 'Various flavored iced teas', 'price' => 120.00],
                    ['name' => 'Coffee and Tea Service', 'description' => 'Premium coffee and tea with condiments', 'price' => 180.00],
                    ['name' => 'Signature Mocktails', 'description' => 'Non-alcoholic mixed drinks', 'price' => 200.00],
                    ['name' => 'Soda and Soft Drinks', 'description' => 'Assorted carbonated beverages', 'price' => 100.00],
                    ['name' => 'Infused Water Station', 'description' => 'Water infused with fresh fruits and herbs', 'price' => 80.00],
                ]
            );
        }

        /**
         * Helper method to create a menu with its items
         */
        private function createMenu(string $name, string $description, array $items): void
        {
            $menu = Menu::create([
                'name' => $name,
                'description' => $description,
                'is_active' => true,
            ]);

            foreach ($items as $item) {
                MenuItem::create([
                    'menu_id' => $menu->id,
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'is_available' => true
                ]);
            }
        }
    }
