# Cartiva Database Schema & Entity Relationships

Detailed overview of the relational database tables powering the Cartiva group-buying platform.

## Key Tables

### `products`
- `id` (BIGINT, PK)
- `seller_id` (BIGINT, FK -> users.id)
- `category_id` (BIGINT, FK -> categories.id)
- `title` (VARCHAR)
- `slug` (VARCHAR, UNIQUE)
- `single_price` (DECIMAL 10,2)
- `group_price` (DECIMAL 10,2)
- `group_size_required` (INT, default 2)
- `discount_tiers` (JSON, nullable)
- `min_quota_to_ship` (INT, nullable)
- `max_buyers_limit` (INT, nullable)
- `stock` (INT)
- `is_active` (BOOLEAN)

### `group_buy_sessions`
- `id` (BIGINT, PK)
- `product_id` (BIGINT, FK -> products.id)
- `leader_user_id` (BIGINT, FK -> users.id, nullable)
- `group_code` (VARCHAR 10, UNIQUE)
- `required_members` (INT)
- `current_members` (INT, default 0)
- `status` (ENUM: 'active', 'completed', 'expired')
- `expires_at` (TIMESTAMP)

### `group_buy_members`
- `id` (BIGINT, PK)
- `group_buy_session_id` (BIGINT, FK -> group_buy_sessions.id)
- `user_id` (BIGINT, FK -> users.id)
- `is_leader` (BOOLEAN, default false)
- `joined_at` (TIMESTAMP)

### `orders`
- `id` (BIGINT, PK)
- `user_id` (BIGINT, FK -> users.id)
- `order_number` (VARCHAR, UNIQUE)
- `order_type` (ENUM: 'single', 'group_buy')
- `group_buy_session_id` (BIGINT, FK -> group_buy_sessions.id, nullable)
- `total_amount` (DECIMAL 10,2)
- `payment_status` (ENUM: 'pending', 'paid', 'refunded')
- `order_status` (ENUM: 'pending_group', 'processing', 'shipped', 'delivered', 'cancelled')
