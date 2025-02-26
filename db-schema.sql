-- Wildlife Haven Database Schema
-- MySQL implementation
CREATE DATABASE IF NOT EXISTS wildlife;

USE wildlife;

-- Drop tables if they exist (in reverse order of creation to avoid FK constraints)
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Transactions;
DROP TABLE IF EXISTS UserEvents;
DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS UserAchievements;
DROP TABLE IF EXISTS Achievements;
DROP TABLE IF EXISTS Messages;
DROP TABLE IF EXISTS Friends;
DROP TABLE IF EXISTS ForumPosts;
DROP TABLE IF EXISTS ForumCategories;
DROP TABLE IF EXISTS Conservation;
DROP TABLE IF EXISTS ConservationPartners;
DROP TABLE IF EXISTS UserItems;
DROP TABLE IF EXISTS Items;
DROP TABLE IF EXISTS Habitats;
DROP TABLE IF EXISTS FocusSessions;
DROP TABLE IF EXISTS Creatures;
DROP TABLE IF EXISTS CreatureSpecies;
DROP TABLE IF EXISTS Users;

SET FOREIGN_KEY_CHECKS = 1;

-- Create tables

-- Users table
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    avatar_url VARCHAR(255),
    bio TEXT,
    streak_days INT DEFAULT 0,
    total_focus_time INT DEFAULT 0, -- in minutes
    coins_balance INT DEFAULT 0,
    subscription_status ENUM('free', 'premium') DEFAULT 'free',
    last_login_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CreatureSpecies table
CREATE TABLE CreatureSpecies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    habitat_type ENUM('forest', 'ocean', 'mountain', 'sky', 'cosmic', 'enchanted') NOT NULL,
    rarity ENUM('common', 'uncommon', 'rare', 'legendary', 'mythical') NOT NULL,
    focus_requirement INT NOT NULL, -- minutes needed to hatch/evolve
    growth_stages JSON NOT NULL, -- JSON with stage requirements
    real_world_inspiration VARCHAR(100),
    conservation_fact TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_habitat_type (habitat_type),
    INDEX idx_rarity (rarity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Items table
CREATE TABLE Items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('habitat_decoration', 'creature_accessory', 'consumable') NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price INT NOT NULL,
    rarity ENUM('common', 'uncommon', 'rare', 'legendary', 'mythical') DEFAULT 'common',
    is_limited_edition BOOLEAN DEFAULT FALSE,
    conservation_impact TEXT,
    available_from DATETIME,
    available_until DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_type (type),
    INDEX idx_rarity (rarity),
    INDEX idx_available (available_from, available_until)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ConservationPartners table
CREATE TABLE ConservationPartners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    website_url VARCHAR(255),
    logo_url VARCHAR(255),
    focus_to_impact_ratio FLOAT NOT NULL, -- e.g., minutes to trees
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Achievements table
CREATE TABLE Achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    icon_url VARCHAR(255),
    requirement_type VARCHAR(50) NOT NULL, -- e.g., "focus_time", "creatures_collected"
    requirement_value INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_requirement (requirement_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Events table
CREATE TABLE Events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    rewards JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_dates (start_date, end_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ForumCategories table
CREATE TABLE ForumCategories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    order_index INT NOT NULL DEFAULT 0,
    parent_category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_category_id) REFERENCES ForumCategories(id) ON DELETE SET NULL,
    INDEX idx_parent (parent_category_id),
    INDEX idx_order (order_index)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creatures table
CREATE TABLE Creatures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    species_id INT NOT NULL,
    name VARCHAR(100),
    stage ENUM('egg', 'baby', 'juvenile', 'adult', 'mythical') DEFAULT 'egg',
    health INT DEFAULT 100,
    happiness INT DEFAULT 100,
    growth_progress INT DEFAULT 0,
    hatched_at DATETIME,
    last_interaction_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (species_id) REFERENCES CreatureSpecies(id),
    INDEX idx_user (user_id),
    INDEX idx_species (species_id),
    INDEX idx_stage (stage)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Habitats table
CREATE TABLE Habitats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('forest', 'ocean', 'mountain', 'sky', 'cosmic', 'enchanted') NOT NULL,
    level INT DEFAULT 1,
    expansion_level INT DEFAULT 1,
    decorations JSON, -- JSON array of decoration IDs
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- FocusSessions table
CREATE TABLE FocusSessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME,
    duration_minutes INT,
    completed BOOLEAN DEFAULT FALSE,
    focus_score INT, -- 0-100
    coins_earned INT DEFAULT 0,
    creature_id INT,
    platform ENUM('mobile', 'web') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (creature_id) REFERENCES Creatures(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_creature (creature_id),
    INDEX idx_start_time (start_time),
    INDEX idx_completed (completed)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- UserItems (Inventory) table
CREATE TABLE UserItems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT DEFAULT 1,
    is_equipped BOOLEAN DEFAULT FALSE,
    equipped_to INT, -- ID of creature if applicable
    acquired_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES Items(id) ON DELETE CASCADE,
    FOREIGN KEY (equipped_to) REFERENCES Creatures(id) ON DELETE SET NULL,
    UNIQUE KEY unique_user_item (user_id, item_id),
    INDEX idx_user (user_id),
    INDEX idx_item (item_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Conservation table
CREATE TABLE Conservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    partner_organization_id INT NOT NULL,
    type ENUM('tree_planted', 'donation', 'habitat_protected') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    triggered_by VARCHAR(100), -- e.g., "focus_session", "purchase"
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (partner_organization_id) REFERENCES ConservationPartners(id),
    INDEX idx_user (user_id),
    INDEX idx_partner (partner_organization_id),
    INDEX idx_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ForumPosts table
CREATE TABLE ForumPosts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    title VARCHAR(255),
    content TEXT NOT NULL,
    parent_post_id INT,
    is_pinned BOOLEAN DEFAULT FALSE,
    is_locked BOOLEAN DEFAULT FALSE,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES ForumCategories(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_post_id) REFERENCES ForumPosts(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_category (category_id),
    INDEX idx_parent (parent_post_id),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Friends table
CREATE TABLE Friends (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    status ENUM('pending', 'accepted') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (friend_id) REFERENCES Users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_friendship (user_id, friend_id),
    INDEX idx_user (user_id),
    INDEX idx_friend (friend_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Messages table
CREATE TABLE Messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    recipient_id INT NOT NULL,
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipient_id) REFERENCES Users(id) ON DELETE CASCADE,
    INDEX idx_sender (sender_id),
    INDEX idx_recipient (recipient_id),
    INDEX idx_created (created_at),
    INDEX idx_read (is_read)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- UserAchievements table
CREATE TABLE UserAchievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    achievement_id INT NOT NULL,
    earned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (achievement_id) REFERENCES Achievements(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_achievement (user_id, achievement_id),
    INDEX idx_user (user_id),
    INDEX idx_achievement (achievement_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- UserEvents table
CREATE TABLE UserEvents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    progress INT DEFAULT 0,
    completed BOOLEAN DEFAULT FALSE,
    rewards_claimed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES Events(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_event (user_id, event_id),
    INDEX idx_user (user_id),
    INDEX idx_event (event_id),
    INDEX idx_completed (completed)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Transactions table
CREATE TABLE Transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('purchase', 'earning', 'spending') NOT NULL,
    amount INT NOT NULL,
    currency ENUM('coins', 'real_money') NOT NULL,
    description TEXT,
    reference_id VARCHAR(100), -- ID reference to related entity (item, focus session, etc.)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_type (type),
    INDEX idx_currency (currency),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;