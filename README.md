# 

# High-Level Overview of Food Delivery Backend System
## Purpose
The backend system is designed to manage user authentication and authorization for a food delivery website clone. It facilitates the operations of different user roles and handles the core functionalities related to food ordering and restaurant management.

## User Roles
- **Admin**: Oversees the entire system and manages user roles and permissions.
- **Restaurant Owner**: Manages their own restaurant(s), including menus and orders.
- **Customer**: Places orders from available restaurants.
- **Delivery Personnel**: Handles the delivery of orders to customers.
## Key Entities
- **User**: Represents all users in the system, linked to specific roles.
- **Role**: Defines the access level and permissions for users.
- **Restaurant**: Represents a food establishment managed by a restaurant owner.
- **Menu**: Contains a list of menu items offered by a restaurant.
- **MenuItem**: Individual food items available for order.
- **Order**: Represents a customer's order, linked to a restaurant and user.
- **OrderItem**: Specific items within an order.
- **RevenueReport**: Summarizes financial data for a restaurant.
## Authentication
- **JWT Tokens**: Used for secure user authentication and session management.
## Order Management
- Orders are linked to restaurants via the `restaurant_id`  foreign key in the Order entity.
- Order statuses are tracked to manage the order lifecycle effectively.
## Relationships
- **User - Role**: A user is associated with a specific role.
- **User - Restaurant**: A user can own multiple restaurants.
- **Restaurant - Menu**: A restaurant can have multiple menus.
- **Menu - MenuItem**: A menu contains multiple menu items.
- **Order - User**: A user can place multiple orders.
- **Order - Restaurant**: An order is associated with a specific restaurant.
- **Order - OrderItem**: An order consists of multiple order items.
- **Restaurant - RevenueReport**: Each restaurant has# Food Delivery Website Backend Documentation
## Overview
This document provides an overview of the backend system for the food delivery website clone. It includes details on the key entities, their relationships, and the main features of the system.

## Table of Contents
1. [﻿Entities and Relationships](https://#entities-and-relationships) 
2. [﻿User Management](https://#user-management) 
3. [﻿Restaurant Management](https://#restaurant-management) 
4. [﻿Menu and Menu Items](https://#menu-and-menu-items) 
5. [﻿Order Management](https://#order-management) 
6. [﻿Revenue Reporting](https://#revenue-reporting) 
7. [﻿Authentication and Authorization](https://#authentication-and-authorization) 
## Entities and Relationships
### Key Entities
- **User**
    - Attributes: `id` , `name` , `email` , `password` , `role_id` , `created_at` , `updated_at` 
    - Relationships: Belongs to a Role
- **Role**
    - Attributes: `id` , `name` 
    - Relationships: Has many Users
- **Restaurant**
    - Attributes: `id` , `user_id` , `name` , `address` , `phone` , `status` , `created_at` , `updated_at` 
    - Relationships: Belongs to a User, has many Menus
- **Menu**
    - Attributes: `id` , `restaurant_id` , `name` , `description` , `created_at` , `updated_at` 
    - Relationships: Belongs to a Restaurant, has many MenuItems
- **MenuItem**
    - Attributes: `id` , `menu_id` , `name` , `description` , `price` , `status` , `created_at` , `updated_at` 
    - Relationships: Belongs to a Menu
- **Order**
    - Attributes: `id` , `user_id` , `restaurant_id` , `status` , `total_amount` , `created_at` , `updated_at` 
    - Relationships: Belongs to a User, belongs to a Restaurant, has many OrderItems
- **OrderItem**
    - Attributes: `id` , `order_id` , `menu_item_id` , `quantity` , `price` , `created_at` , `updated_at` 
    - Relationships: Belongs to an Order
- **RevenueReport**
    - Attributes: `id` , `restaurant_id` , `total_orders` , `total_revenue` , `report_month` , `created_at` 
    - Relationships: Belongs to a Restaurant
## User Management
### Registration and Login Process
- Describe the process for user registration.
- Outline the login process, including any validation steps.
### Role Assignment and Management
- Explain how roles are assigned to users.
- Detail the management of user roles.
### Password Reset Functionality
- Describe the steps for resetting a user's password.
## Restaurant Management
### Adding and Updating Restaurant Details
- Outline the process for adding a new restaurant.
- Describe how to update existing restaurant details.
### Managing Restaurant Status
- Explain how to change a restaurant's status (active/inactive).
### Linking Restaurants to Users
- Detail the process for associating a restaurant with a user.
## Menu and Menu Items
### Managing Menus
- Describe how to create and update menus for a restaurant.
### Managing Menu Items
- Outline the process for adding, updating, and removing menu items.
## Order Management
### Order Creation and Processing
- Explain how orders are created and processed.
### Managing Order Statuses
- Detail the scheduled batch process for updating order statuses.
## Revenue Reporting
### Generating Revenue Reports
- Describe how revenue reports are generated for each restaurant.
## Authentication and Authorization
### JWT Tokens
- Explain the use of JWT tokens for authentication.
### Role-Based Permissions
- Detail how role-based permissions are implemented and enforced.


