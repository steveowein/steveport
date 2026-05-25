-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2026 at 02:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio_steve`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `issuer` varchar(100) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `year` varchar(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `title`, `issuer`, `month`, `year`, `image`, `keywords`, `description`) VALUES
(1, 'Shielded Metal Arc Welding (SMAW) NC II', 'TESDA - Grade 12', 'May', '2024', NULL, 'SMAW, Welding, Technical', 'National Certificate II in Shielded Metal Arc Welding.'),
(2, 'Research Presentation Certificate – Perceived Learning Outcomes Study', 'Davao del Norte State College – Institute of Computing', 'May', '2026', 'cert_6a139833bd917.png', 'Research Presentation, Academic Research, Online Learning, Learning Outcomes, BSIT, Public Presentation, Communication Skills, Research Skills', 'Awarded a Certificate of Recognition for successfully presenting a research study during the Public Research Colloquium 2026, demonstrating skills in research analysis, communication, and presentation.');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `degree` varchar(100) DEFAULT NULL,
  `institution` varchar(100) DEFAULT NULL,
  `year` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `degree`, `institution`, `year`) VALUES
(1, 'Bachelor of Science in Information Systems', 'Davao del Norte State College', '2024'),
(2, 'Technical-Vocational-Livelihood (SMAW)', 'Balagunan National High School', '2022-2024');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `role`, `date`, `description`) VALUES
(1, 'Helper / SMAW', 'Jun 2024', '- Assisted in technical tasks and supported instructors during practical sessions.\n- Helped organize and maintain workshop tools and materials.\n- Learned and performed basic SMAW procedures under supervision.\n- Gained hands-on experience and practical skills in welding and technical operations.');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `career_objective` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT 'steve.jpg',
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_tagline` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`id`, `full_name`, `address`, `contact_number`, `email`, `linkedin`, `career_objective`, `profile_image`, `hero_title`, `hero_tagline`) VALUES
(1, 'STEVE OWEIN G. PRESIDENTE', 'Balagunan, Sto. Tomas, Davao del Norte', '0993-461-7106', 'steveoweinpresidente@gmail.com', 'https://www.linkedin.com/in/steve-owein-presidente-68b28a409', 'Motivated Bachelor of Science in Information Systems student with practical experience in technical tasks, simple UI design in Figma, and SMAW operations. Desire to use problem solving, adaptability and teamwork skills in a professional setting, and to acquire industry experience and help the organization grow.', 'steve.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `tech_stack` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `project_date` varchar(50) DEFAULT NULL,
  `additional_images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `icon`) VALUES
(1, 'Basic UI Design', 'Crafting clean, intuitive, and modern user interfaces using Figma, focusing on layout and user experience.', 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/figma/figma-original.svg'),
(2, 'SMAW Operations', 'Executing technical tasks and Shielded Metal Arc Welding procedures safely and precisely based on NC II standards.', 'https://img.icons8.com/color/96/000000/fire-element.png'),
(3, 'Technical Support', 'Applying Information Systems knowledge to solve technical problems and organize tools and materials.', 'https://img.icons8.com/color/96/000000/maintenance.png');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `skill_name` varchar(100) DEFAULT NULL,
  `level` int(11) DEFAULT 0,
  `icon_image` varchar(255) DEFAULT NULL,
  `icon_class` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill_name`, `level`, `icon_image`, `icon_class`) VALUES
(1, 'Figma (Basic UI Design)', 80, NULL, 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/figma/figma-original.svg'),
(2, 'Adaptability', 90, NULL, 'https://img.icons8.com/color/96/000000/refresh.png'),
(3, 'Teamwork', 95, NULL, 'https://img.icons8.com/color/96/000000/group.png'),
(4, 'Time management', 85, NULL, 'https://img.icons8.com/color/96/000000/clock.png'),
(5, 'Information Systems', 80, NULL, 'https://img.icons8.com/color/96/000000/network.png'),
(6, 'SMAW Operations', 75, NULL, 'https://img.icons8.com/color/96/000000/fire-element.png'),
(7, 'Problem Solving', 90, NULL, 'https://img.icons8.com/color/96/000000/idea.png'),
(8, 'Technical Tasks', 85, NULL, 'https://img.icons8.com/color/96/000000/maintenance.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$tjcgEuZ0dtbv6EOrbSZuZunGPLJj1nUY6pk0zhzYZKK/QJN46Rg66');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `visit_date` date DEFAULT NULL,
  `visits` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `ip_address`, `visit_date`, `visits`) VALUES
(1, '::1', '2026-05-25', 158);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
