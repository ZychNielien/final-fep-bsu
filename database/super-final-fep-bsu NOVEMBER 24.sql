-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 07:00 PM
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
-- Database: `super-final-fep-bsu`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year_semester`
--

CREATE TABLE `academic_year_semester` (
  `id` int(11) NOT NULL,
  `paraSa` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `isOpen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_year_semester`
--

INSERT INTO `academic_year_semester` (`id`, `paraSa`, `semester`, `academic_year`, `isOpen`) VALUES
(1, 'studentEvaluation', 'FIRST', '2024-2025', 1),
(2, 'classroomObservation', 'SECOND', '2024-2025', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assigned_subject`
--

CREATE TABLE `assigned_subject` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `S_time_id` int(11) NOT NULL,
  `E_time_id` int(11) NOT NULL,
  `day_id_2` int(11) NOT NULL,
  `S_time_id_2` int(11) NOT NULL,
  `E_time_id_2` int(11) NOT NULL,
  `slot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned_subject`
--

INSERT INTO `assigned_subject` (`id`, `subject_id`, `faculty_id`, `section_id`, `day_id`, `S_time_id`, `E_time_id`, `day_id_2`, `S_time_id_2`, `E_time_id_2`, `slot`) VALUES
(34, 1, 1, 16, 1, 1, 4, 0, 0, 0, 40),
(35, 6, 2, 16, 1, 5, 10, 0, 0, 0, 40),
(36, 7, 3, 16, 1, 11, 13, 0, 0, 0, 40),
(37, 8, 4, 16, 4, 1, 4, 0, 0, 0, 40),
(38, 9, 1, 16, 3, 4, 9, 0, 0, 0, 40),
(39, 10, 5, 16, 2, 4, 8, 0, 0, 0, 40),
(41, 51, 11, 1, 2, 1, 3, 4, 4, 5, 40),
(42, 49, 13, 1, 2, 4, 6, 4, 1, 2, 40),
(46, 59, 2, 25, 1, 1, 4, 2, 5, 7, 40),
(47, 60, 2, 25, 4, 1, 4, 5, 8, 10, 40),
(48, 57, 1, 30, 1, 5, 8, 4, 1, 3, 40),
(49, 58, 1, 30, 3, 1, 4, 5, 6, 8, 40),
(50, 19, 12, 27, 3, 1, 4, 5, 7, 9, 40),
(51, 61, 5, 27, 2, 1, 3, 5, 4, 7, 40),
(52, 41, 3, 4, 1, 1, 4, 4, 5, 7, 40),
(53, 43, 11, 4, 1, 5, 8, 0, 0, 0, 40),
(54, 4, 12, 1, 1, 1, 3, 3, 5, 8, 40),
(56, 20, 5, 30, 1, 1, 4, 0, 0, 0, 40),
(59, 36, 6, 8, 2, 4, 6, 5, 3, 6, 40),
(60, 40, 23, 8, 1, 6, 9, 4, 10, 11, 40),
(61, 33, 25, 8, 1, 3, 6, 5, 9, 12, 40),
(62, 39, 22, 8, 4, 10, 12, 0, 0, 0, 40),
(63, 34, 24, 8, 1, 1, 3, 0, 0, 0, 40),
(64, 37, 8, 8, 2, 1, 3, 4, 4, 8, 40),
(65, 35, 19, 8, 2, 7, 10, 4, 4, 6, 40),
(66, 38, 21, 8, 4, 9, 10, 0, 0, 0, 40),
(67, 24, 8, 31, 3, 4, 7, 5, 1, 3, 40),
(68, 20, 9, 31, 3, 9, 10, 5, 11, 13, 40),
(69, 23, 11, 31, 5, 7, 9, 0, 0, 0, 40),
(70, 21, 10, 31, 6, 7, 11, 0, 0, 0, 40),
(71, 57, 7, 31, 3, 1, 4, 0, 0, 0, 40),
(72, 58, 7, 31, 6, 4, 6, 0, 0, 0, 40),
(73, 4, 9, 2, 1, 1, 3, 0, 0, 0, 40),
(74, 58, 1, 32, 4, 1, 4, 0, 0, 0, 40);

-- --------------------------------------------------------

--
-- Table structure for table `average_ratings`
--

CREATE TABLE `average_ratings` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teaching_average` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `average_ratings`
--

INSERT INTO `average_ratings` (`id`, `student_id`, `teaching_average`) VALUES
(5, NULL, 4.50),
(6, NULL, 4.33),
(7, NULL, 3.83),
(8, NULL, 4.67),
(9, NULL, 3.17),
(10, NULL, 4.83),
(11, NULL, 4.00),
(12, NULL, 4.33),
(13, NULL, 3.83),
(14, NULL, 3.50),
(15, NULL, 3.33),
(16, NULL, 3.50),
(17, NULL, 3.50),
(18, NULL, 3.83),
(19, NULL, 4.50),
(20, NULL, 3.17),
(21, NULL, 3.67),
(22, NULL, 3.83),
(23, NULL, 2.67),
(24, NULL, 2.50),
(25, NULL, 3.83),
(26, NULL, 4.00),
(27, NULL, 3.17),
(28, NULL, 3.50),
(29, NULL, 3.67),
(30, NULL, 2.50),
(31, NULL, 3.00),
(32, NULL, 3.50),
(33, NULL, 3.50),
(34, NULL, 3.67),
(35, NULL, 3.50),
(36, NULL, 3.83),
(37, NULL, 3.33),
(38, NULL, 4.33),
(39, NULL, 4.33),
(40, NULL, 3.67),
(41, NULL, 3.83),
(42, NULL, 3.50),
(43, NULL, 3.00),
(44, NULL, 2.67),
(45, NULL, 2.50),
(46, NULL, 3.67),
(47, NULL, 3.50),
(48, NULL, 3.83),
(49, NULL, 3.67),
(50, NULL, 2.67),
(51, NULL, 3.83),
(52, NULL, 3.83),
(53, NULL, 4.00),
(54, NULL, 3.50),
(55, NULL, 4.17),
(56, NULL, 3.83),
(57, NULL, 3.83),
(58, NULL, 2.67),
(59, NULL, 3.33),
(60, NULL, 3.83),
(61, NULL, 3.67),
(62, NULL, 2.50),
(63, NULL, 3.83),
(64, NULL, 3.50),
(65, NULL, 3.17);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `faculty_Id` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `room` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `selected_date` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `slot` varchar(255) NOT NULL,
  `evaluation_status` varchar(255) NOT NULL,
  `fromFacultyID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `faculty_Id`, `course`, `name`, `room`, `academic_year`, `semester`, `selected_date`, `start_time`, `end_time`, `slot`, `evaluation_status`, `fromFacultyID`) VALUES
(226, 19, 'Phy 101', 'Jasmin Pesigan', 'Room 1', '2024-2025', 'FIRST', '2024-11-18', '7', '9', '1', '1', ''),
(227, 21, 'CpE 405', 'Ariane Villanueva', 'Room 2', '2024-2025', 'FIRST', '2024-11-18', '10', '11', '1', '1', ''),
(228, 6, 'IT 212', 'Erwin De Castro', 'Room 1', '2024-2025', 'FIRST', '2024-11-19', '9', '12', '1', '1', ''),
(229, 23, 'CS 211', 'Michael Ramilo', 'Room 5', '2024-2025', 'FIRST', '2024-11-18', '15', '17', '1', '1', ''),
(230, 22, 'PE 103', 'Bryan Mondres', 'Gymnasium', '2024-2025', 'FIRST', '2024-11-22', '14', '16', '1', '0', ''),
(231, 24, 'Litr 102', 'Hazel Joy Banayo', 'Room 3', '2024-2025', 'FIRST', '2024-11-20', '9', '11', '1', '1', ''),
(232, 8, 'IT 211', 'Mary Jean Abejuela', 'Room 2', '2024-2025', 'FIRST', '2024-11-20', '14', '16', '1', '1', ''),
(233, 8, 'IT 211', 'Mary Jean Abejuela', 'cxv', '2024-2025', 'SECOND', '2024-12-09', '7', '9', '1', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `classroomcategories`
--

CREATE TABLE `classroomcategories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `linkOne` text NOT NULL,
  `linkTwo` text NOT NULL,
  `linkThree` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroomcategories`
--

INSERT INTO `classroomcategories` (`id`, `categories`, `linkOne`, `linkTwo`, `linkThree`) VALUES
(21, 'CONTENT ORGANIZATION ', 'https://youtu.be/1aWT-0mVbls?si=PZoBMtKf3zE1YwHx', 'https://youtu.be/T-6tWJsfceU?si=VWILVtvbXfeucuAf', ''),
(22, 'PRESENTATION', 'https://youtube.com/playlist?list=PLtcVLF1AuAwCUOjau1SUUVh6zcs2cfFM_&si=-VlQ2C7x1EKCUNq8 ', 'https://youtube.com/playlist?list=PL2fUZ7TZy_xfTR2Go-QhyQET5Bu7jpb1t&si=RTE-g2vOK0V76jVR', ''),
(23, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'https://youtube.com/playlist?list=PLYQoKHLHdAfx5auNy8JT9Imj6TQK6UhXw&si=MxS3R8wMtO0wLZst', 'https://www.udemy.com/course/online-course-creation-introduction-to-instructional-design/?couponCode=ST14MT101024', 'https://www.nicheacademy.com/blog/effective-interaction-in-online-courses'),
(24, 'INSTRUCTIONAL MATERIALS AND ENVIRONMENT ', 'https://youtu.be/SiAaApeJo9w?si=XyK-v0WsI4GjprPU', 'https://youtu.be/GeXGY3uy41k?si=1NjRq9diBxXj9yQ8', ''),
(25, 'CONTENT KNOWLEDGE AND RELEVANCE ', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `classroomcriteria`
--

CREATE TABLE `classroomcriteria` (
  `id` int(11) NOT NULL,
  `classroomCategories` varchar(255) NOT NULL,
  `classroomCriteria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroomcriteria`
--

INSERT INTO `classroomcriteria` (`id`, `classroomCategories`, `classroomCriteria`) VALUES
(68, 'CONTENT ORGANIZATION ', 'Made clear statement of the purpose of the lesson.'),
(69, 'CONTENT ORGANIZATION ', 'Define relationship of this lesson to previous lesson '),
(70, 'CONTENT ORGANIZATION ', 'Presented overview of the lesson '),
(71, 'CONTENT ORGANIZATION ', 'Presented topic with logical sequence '),
(72, 'CONTENT ORGANIZATION ', 'Paced lesson appropriately '),
(73, 'CONTENT ORGANIZATION ', 'Summarized major points of lesson '),
(74, 'CONTENT ORGANIZATION ', 'Responded to problems raised during lesson '),
(75, 'CONTENT ORGANIZATION ', 'Related today\'s lesson to future lessons '),
(76, 'PRESENTATION', 'Projected voice so easily heard '),
(77, 'PRESENTATION', 'Used intonation to vary emphasis '),
(78, 'PRESENTATION', 'Explain things with clarity '),
(79, 'PRESENTATION', 'Maintained eye contact with students '),
(80, 'PRESENTATION', 'Listen to student’s questions and comments '),
(81, 'PRESENTATION', 'Projected non-verbal gestures consistent with intentions '),
(82, 'PRESENTATION', 'Defined unfamiliar terms, concepts and principle '),
(83, 'PRESENTATION', 'Presented examples to clarify points'),
(84, 'PRESENTATION', 'Related important ideas to familiar concepts  '),
(85, 'PRESENTATION', 'Restated important ideas at appropriate times  '),
(86, 'PRESENTATION', 'varied explanation for complex and difficult material '),
(87, 'PRESENTATION', 'Used humor appropriately to strengthen retention and interest '),
(88, 'PRESENTATION', 'Limited use of repetitive phrases and hanging articles  '),
(89, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Encourage student questions '),
(90, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Encourage student discussion '),
(91, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Maintained student attention '),
(92, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Monitor student\'s progress '),
(93, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Gave satisfactory answers to questions  '),
(94, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Responded to nonverbal clues of confusion, boredom, and curiosity  '),
(95, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Paced lesson to allow time for note taking '),
(96, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Encourage students to answer difficult questions '),
(97, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Asked probing questions when necessary '),
(98, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Restated questions and answers when necessary '),
(99, 'INSTRUCTIONS/STUDENT INTERACTIONS ', 'Suggested questions of limited interest to be handled outside class '),
(100, 'INSTRUCTIONAL MATERIALS AND ENVIRONMENT ', 'Maintained adequate classroom facilities '),
(101, 'INSTRUCTIONAL MATERIALS AND ENVIRONMENT ', 'Prepared students for the lesson with appropriate assigned readings  '),
(102, 'INSTRUCTIONAL MATERIALS AND ENVIRONMENT ', 'Supported lesson with useful classroom discussion and exercises '),
(103, 'INSTRUCTIONAL MATERIALS AND ENVIRONMENT ', 'Presented helpful audio-visual material to support lesson organization and major points.  '),
(104, 'INSTRUCTIONAL MATERIALS AND ENVIRONMENT ', 'Provide relevant written assignments '),
(105, 'CONTENT KNOWLEDGE AND RELEVANCE ', 'Presented material worth knowing '),
(106, 'CONTENT KNOWLEDGE AND RELEVANCE ', 'Presented material appropriate to student knowledge and background '),
(107, 'CONTENT KNOWLEDGE AND RELEVANCE ', 'Cited authorities to support statements '),
(108, 'CONTENT KNOWLEDGE AND RELEVANCE ', 'Presented materials appropriate to stated purpose of the course '),
(109, 'CONTENT KNOWLEDGE AND RELEVANCE ', 'Made discussion between fact and opinion '),
(110, 'CONTENT KNOWLEDGE AND RELEVANCE ', 'Presented divergent viewpoints when appropriate '),
(111, 'CONTENT KNOWLEDGE AND RELEVANCE ', 'Demonstrate command of subject matter ');

-- --------------------------------------------------------

--
-- Table structure for table `classroomdate`
--

CREATE TABLE `classroomdate` (
  `id` int(11) NOT NULL,
  `classdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroomdate`
--

INSERT INTO `classroomdate` (`id`, `classdate`) VALUES
(1, '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `classroomobservation`
--

CREATE TABLE `classroomobservation` (
  `id` int(11) NOT NULL,
  `toFacultyID` int(11) NOT NULL,
  `fromFacultyID` int(11) NOT NULL,
  `toFaculty` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `courseTitle` varchar(255) NOT NULL,
  `lengthOfCourse` varchar(255) NOT NULL,
  `lengthOfObservation` varchar(255) NOT NULL,
  `subjectMatter` text NOT NULL,
  `fromFaculty` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `doneStatus` int(11) NOT NULL,
  `commentCONTENTORGANIZATION21` varchar(255) DEFAULT NULL,
  `CONTENTORGANIZATION68` varchar(255) DEFAULT NULL,
  `CONTENTORGANIZATION69` varchar(255) DEFAULT NULL,
  `CONTENTORGANIZATION70` varchar(255) DEFAULT NULL,
  `CONTENTORGANIZATION71` varchar(255) DEFAULT NULL,
  `CONTENTORGANIZATION72` varchar(255) DEFAULT NULL,
  `CONTENTORGANIZATION73` varchar(255) DEFAULT NULL,
  `CONTENTORGANIZATION74` varchar(255) DEFAULT NULL,
  `CONTENTORGANIZATION75` varchar(255) DEFAULT NULL,
  `commentPRESENTATION22` varchar(255) DEFAULT NULL,
  `PRESENTATION76` varchar(255) DEFAULT NULL,
  `PRESENTATION77` varchar(255) DEFAULT NULL,
  `PRESENTATION78` varchar(255) DEFAULT NULL,
  `PRESENTATION79` varchar(255) DEFAULT NULL,
  `PRESENTATION80` varchar(255) DEFAULT NULL,
  `PRESENTATION81` varchar(255) DEFAULT NULL,
  `PRESENTATION82` varchar(255) DEFAULT NULL,
  `PRESENTATION83` varchar(255) DEFAULT NULL,
  `PRESENTATION84` varchar(255) DEFAULT NULL,
  `PRESENTATION85` varchar(255) DEFAULT NULL,
  `PRESENTATION86` varchar(255) DEFAULT NULL,
  `PRESENTATION87` varchar(255) DEFAULT NULL,
  `PRESENTATION88` varchar(255) DEFAULT NULL,
  `commentINSTRUCTIONSSTUDENTINTERACTIONS23` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS89` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS90` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS91` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS92` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS93` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS94` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS95` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS96` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS97` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS98` varchar(255) DEFAULT NULL,
  `INSTRUCTIONSSTUDENTINTERACTIONS99` varchar(255) DEFAULT NULL,
  `commentINSTRUCTIONALMATERIALSANDENVIRONMENT24` varchar(255) DEFAULT NULL,
  `INSTRUCTIONALMATERIALSANDENVIRONMENT100` varchar(255) DEFAULT NULL,
  `INSTRUCTIONALMATERIALSANDENVIRONMENT101` varchar(255) DEFAULT NULL,
  `INSTRUCTIONALMATERIALSANDENVIRONMENT102` varchar(255) DEFAULT NULL,
  `INSTRUCTIONALMATERIALSANDENVIRONMENT103` varchar(255) DEFAULT NULL,
  `INSTRUCTIONALMATERIALSANDENVIRONMENT104` varchar(255) DEFAULT NULL,
  `commentCONTENTKNOWLEDGEANDRELEVANCE25` varchar(255) DEFAULT NULL,
  `CONTENTKNOWLEDGEANDRELEVANCE105` varchar(255) DEFAULT NULL,
  `CONTENTKNOWLEDGEANDRELEVANCE106` varchar(255) DEFAULT NULL,
  `CONTENTKNOWLEDGEANDRELEVANCE107` varchar(255) DEFAULT NULL,
  `CONTENTKNOWLEDGEANDRELEVANCE108` varchar(255) DEFAULT NULL,
  `CONTENTKNOWLEDGEANDRELEVANCE109` varchar(255) DEFAULT NULL,
  `CONTENTKNOWLEDGEANDRELEVANCE110` varchar(255) DEFAULT NULL,
  `CONTENTKNOWLEDGEANDRELEVANCE111` varchar(255) DEFAULT NULL,
  `QUESTIONNO10` varchar(255) DEFAULT NULL,
  `QUESTIONNO11` varchar(255) DEFAULT NULL,
  `QUESTIONNO12` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroomobservation`
--

INSERT INTO `classroomobservation` (`id`, `toFacultyID`, `fromFacultyID`, `toFaculty`, `semester`, `academic_year`, `courseTitle`, `lengthOfCourse`, `lengthOfObservation`, `subjectMatter`, `fromFaculty`, `date`, `doneStatus`, `commentCONTENTORGANIZATION21`, `CONTENTORGANIZATION68`, `CONTENTORGANIZATION69`, `CONTENTORGANIZATION70`, `CONTENTORGANIZATION71`, `CONTENTORGANIZATION72`, `CONTENTORGANIZATION73`, `CONTENTORGANIZATION74`, `CONTENTORGANIZATION75`, `commentPRESENTATION22`, `PRESENTATION76`, `PRESENTATION77`, `PRESENTATION78`, `PRESENTATION79`, `PRESENTATION80`, `PRESENTATION81`, `PRESENTATION82`, `PRESENTATION83`, `PRESENTATION84`, `PRESENTATION85`, `PRESENTATION86`, `PRESENTATION87`, `PRESENTATION88`, `commentINSTRUCTIONSSTUDENTINTERACTIONS23`, `INSTRUCTIONSSTUDENTINTERACTIONS89`, `INSTRUCTIONSSTUDENTINTERACTIONS90`, `INSTRUCTIONSSTUDENTINTERACTIONS91`, `INSTRUCTIONSSTUDENTINTERACTIONS92`, `INSTRUCTIONSSTUDENTINTERACTIONS93`, `INSTRUCTIONSSTUDENTINTERACTIONS94`, `INSTRUCTIONSSTUDENTINTERACTIONS95`, `INSTRUCTIONSSTUDENTINTERACTIONS96`, `INSTRUCTIONSSTUDENTINTERACTIONS97`, `INSTRUCTIONSSTUDENTINTERACTIONS98`, `INSTRUCTIONSSTUDENTINTERACTIONS99`, `commentINSTRUCTIONALMATERIALSANDENVIRONMENT24`, `INSTRUCTIONALMATERIALSANDENVIRONMENT100`, `INSTRUCTIONALMATERIALSANDENVIRONMENT101`, `INSTRUCTIONALMATERIALSANDENVIRONMENT102`, `INSTRUCTIONALMATERIALSANDENVIRONMENT103`, `INSTRUCTIONALMATERIALSANDENVIRONMENT104`, `commentCONTENTKNOWLEDGEANDRELEVANCE25`, `CONTENTKNOWLEDGEANDRELEVANCE105`, `CONTENTKNOWLEDGEANDRELEVANCE106`, `CONTENTKNOWLEDGEANDRELEVANCE107`, `CONTENTKNOWLEDGEANDRELEVANCE108`, `CONTENTKNOWLEDGEANDRELEVANCE109`, `CONTENTKNOWLEDGEANDRELEVANCE110`, `CONTENTKNOWLEDGEANDRELEVANCE111`, `QUESTIONNO10`, `QUESTIONNO11`, `QUESTIONNO12`) VALUES
(73, 19, 1, 'Jasmin Pesigan', 'FIRST', '2024-2025', 'Phy 101', '2 HOURS', '1 Hour', 'Subject Matter Treated', 'Shiela Marie Garcia', 'November 18, 2024', 0, 'Aenean eget eros ornare, ornare metus non, feugiat odio.', '4', '5', '4', '4', '5', '4', '5', '4', 'Sed id tempus sapien. Morbi diam mi, vulputate non massa quis, tincidunt interdum justo.', '3', '4', '3', '4', '5', '4', '3', '4', '4', '5', '4', '5', '4', 'Etiam non nisi varius metus lobortis mollis vel interdum leo.', '3', '4', '3', '4', '5', '4', '5', '4', '4', '3', '4', 'Sed felis ipsum, sagittis eu magna id, cursus consectetur mauris.', '2', '3', '4', '4', '5', 'Quisque nec tempus sapien.', '4', '5', '5', '5', '4', '5', '3', 'Sed varius elit felis, eu tincidunt enim dictum at. Curabitur volutpat enim nulla, in sagittis neque consectetur vitae.', 'Proin ut mattis ipsum.', 'Cras feugiat lectus orci, vel venenatis velit accumsan vitae.'),
(74, 23, 1, 'Michael Ramilo', 'FIRST', '2024-2025', 'CS 211', '2 hours', '1 hour', 'Subject matter', 'Shiela Marie Garcia', 'November 18, 2024', 0, 'Fusce non sem in lacus porttitor volutpat id cursus massa.', '4', '5', '4', '5', '4', '5', '4', '4', 'Sed semper nulla ut condimentum condimentum.', '3', '4', '5', '4', '5', '4', '4', '4', '5', '5', '5', '4', '3', 'Donec est tellus, laoreet ut tempus ut, cursus id tortor.', '5', '4', '3', '2', '1', '2', '3', '4', '5', '4', '3', 'Pellentesque id laoreet est. Vestibulum a pretium nisl.', '2', '3', '3', '4', '4', 'Suspendisse sodales tellus vehicula quam tincidunt', '3', '4', '3', '4', '5', '4', '5', 'ac malesuada lacus imperdiet. Aliquam pulvinar gravida lectus quis luctus.', 'Integer laoreet odio nec libero pulvinar dictum.', 'Donec luctus velit id dolor feugiat accumsan.'),
(75, 21, 1, 'Ariane Villanueva', 'FIRST', '2024-2025', 'CpE 405', '1 hour', '1 hour', 'Subject matter', 'Shiela Marie Garcia', 'November 18, 2024', 0, 'Nunc urna tortor, dictum facilisis imperdiet in, lobortis at ante.', '1', '2', '3', '4', '4', '4', '5', '5', 'Sed ut nisi sit amet purus pharetra consequat non nec mauris.', '2', '3', '3', '3', '3', '4', '4', '4', '5', '4', '5', '5', '4', 'Curabitur congue suscipit nisi a vehicula. Proin lacus leo, imperdiet consectetur nulla non, tempor fermentum justo.', '3', '3', '3', '4', '3', '4', '4', '5', '4', '5', '4', 'Cras a euismod dolor. Cras ut sapien ut urna ullamcorper condimentum.', '2', '3', '3', '3', '4', 'Mauris blandit lacus at lacus sagittis rutrum.', '2', '3', '3', '3', '4', '4', '5', 'Etiam suscipit consequat dignissim.', 'Pellentesque hendrerit vitae mi sed varius. Vivamus eros erat, tempus sit amet mi quis, ultrices porta arcu. Quisque at diam nisl.', 'Pellentesque maximus bibendum congue. Phasellus lorem elit, suscipit sed nisi et, mattis hendrerit dolor.'),
(76, 6, 1, 'Erwin De Castro', 'FIRST', '2024-2025', 'IT 212', '3 hours', '1 hour', 'Subject matter', 'Shiela Marie Garcia', 'November 19, 2024', 0, 'Phasellus vitae lorem tellus.', '2', '3', '4', '4', '4', '5', '4', '5', 'Donec fringilla nisl vitae ipsum pulvinar, et mollis dui sagittis. Integer sed dolor vel tortor ultricies interdum.', '3', '4', '3', '4', '4', '4', '5', '4', '5', '4', '3', '4', '5', 'In tempus magna id lorem malesuada tempor.', '3', '4', '3', '4', '3', '4', '3', '4', '4', '5', '4', 'Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', '3', '4', '3', '4', '3', 'Suspendisse sed rhoncus nulla.', '2', '3', '3', '3', '4', '3', '4', 'Integer viverra leo ante, nec auctor turpis placerat sit amet.', 'Nulla ultricies tortor et pretium condimentum. Vestibulum bibendum dignissim leo, non dictum justo dignissim porta.', 'Aenean arcu odio, egestas vel pellentesque et, sodales nec lacus.'),
(77, 24, 1, 'Hazel Joy Banayo', 'FIRST', '2024-2025', 'Litr 102', '2 hours', '1 hour', 'Subject matter', 'Shiela Marie Garcia', 'November 20, 2024', 0, 'Sed blandit consequat erat, eu interdum tortor laoreet et.', '3', '3', '4', '3', '4', '5', '4', '3', 'Maecenas magna metus, dictum accumsan mauris sed, auctor venenatis diam.', '2', '3', '3', '4', '3', '4', '5', '3', '4', '5', '3', '4', '5', 'Aliquam ac enim diam.', '3', '4', '3', '4', '3', '4', '3', '4', '5', '4', '3', 'Ut et nunc ac mauris viverra venenatis.', '3', '3', '3', '4', '5', 'Donec tincidunt est leo, quis ornare arcu viverra nec.', '2', '3', '4', '3', '4', '5', '4', 'Maecenas dictum fermentum suscipit.', 'Phasellus suscipit vulputate erat nec venenatis.', 'Mauris blandit lacus at lacus sagittis rutrum. Etiam suscipit consequat dignissim.'),
(78, 8, 1, 'Mary Jean Abejuela', 'FIRST', '2024-2025', 'IT 211', '2 hours', '1 hour', 'Subject matter', 'Shiela Marie Garcia', 'November 20, 2024', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '3', '4', '3', '4', '3', '4', '5', '4', 'Curabitur gravida purus ut faucibus accumsan.', '3', '3', '4', '3', '4', '3', '4', '3', '4', '5', '4', '3', '4', 'Cras mi leo, ullamcorper semper gravida in, consectetur in lectus.', '3', '4', '3', '4', '3', '4', '4', '4', '4', '3', '5', 'Fusce in tristique velit. Nullam vitae lacus non dui accumsan vehicula.', '2', '3', '2', '3', '4', 'Morbi tristique porta eros. Fusce imperdiet odio sed iaculis feugiat.', '3', '3', '4', '3', '4', '5', '4', 'Fusce tempus lacus id convallis porta.', 'Maecenas dignissim congue pellentesque.', 'Nulla id ex in tortor ullamcorper congue.');

-- --------------------------------------------------------

--
-- Table structure for table `classroomquestions`
--

CREATE TABLE `classroomquestions` (
  `id` int(11) NOT NULL,
  `questions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classroomquestions`
--

INSERT INTO `classroomquestions` (`id`, `questions`) VALUES
(10, 'What overall impressions do you think the students left this lesson with in terms of content or style? '),
(11, 'What were the instructor\'s major strengths as demonstrated in this observations? '),
(12, 'What suggestions do you have for improving upon this instructor\'s skills? ');

-- --------------------------------------------------------

--
-- Table structure for table `complete_subject`
--

CREATE TABLE `complete_subject` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `sr_code` varchar(30) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_status` int(11) NOT NULL DEFAULT 2,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complete_subject`
--

INSERT INTO `complete_subject` (`id`, `subject_id`, `faculty_id`, `sr_code`, `section_id`, `subject_status`, `semester`, `academic_year`) VALUES
(14, 36, 6, '23-46378', 8, 2, 'FIRST', '2024-2025'),
(15, 40, 23, '23-46378', 8, 2, 'FIRST', '2024-2025'),
(16, 39, 22, '23-46378', 8, 2, 'FIRST', '2024-2025'),
(17, 34, 24, '23-46378', 8, 2, 'FIRST', '2024-2025'),
(18, 37, 8, '23-46378', 8, 2, 'FIRST', '2024-2025'),
(19, 35, 19, '23-46378', 8, 2, 'FIRST', '2024-2025'),
(20, 38, 21, '23-46378', 8, 2, 'FIRST', '2024-2025'),
(21, 36, 6, '23-46379', 8, 2, 'FIRST', '2024-2025'),
(22, 40, 23, '23-46379', 8, 2, 'FIRST', '2024-2025'),
(23, 39, 22, '23-46379', 8, 2, 'FIRST', '2024-2025'),
(24, 34, 24, '23-46379', 8, 2, 'FIRST', '2024-2025'),
(25, 37, 8, '23-46379', 8, 2, 'FIRST', '2024-2025'),
(26, 35, 19, '23-46379', 8, 2, 'FIRST', '2024-2025'),
(27, 38, 21, '23-46379', 8, 2, 'FIRST', '2024-2025'),
(28, 36, 6, '23-46380', 8, 2, 'FIRST', '2024-2025'),
(29, 40, 23, '23-46380', 8, 2, 'FIRST', '2024-2025'),
(30, 39, 22, '23-46380', 8, 2, 'FIRST', '2024-2025'),
(31, 34, 24, '23-46380', 8, 2, 'FIRST', '2024-2025'),
(32, 37, 8, '23-46380', 8, 2, 'FIRST', '2024-2025'),
(33, 35, 19, '23-46380', 8, 2, 'FIRST', '2024-2025'),
(34, 38, 21, '23-46380', 8, 2, 'FIRST', '2024-2025'),
(35, 36, 6, '23-46382', 8, 2, 'FIRST', '2024-2025'),
(36, 40, 23, '23-46382', 8, 2, 'FIRST', '2024-2025'),
(37, 39, 22, '23-46382', 8, 2, 'FIRST', '2024-2025'),
(38, 34, 24, '23-46382', 8, 2, 'FIRST', '2024-2025'),
(39, 37, 8, '23-46382', 8, 2, 'FIRST', '2024-2025'),
(40, 35, 19, '23-46382', 8, 2, 'FIRST', '2024-2025'),
(41, 38, 21, '23-46382', 8, 2, 'FIRST', '2024-2025'),
(42, 36, 6, '23-46384', 8, 2, 'FIRST', '2024-2025'),
(43, 40, 23, '23-46384', 8, 2, 'FIRST', '2024-2025'),
(44, 39, 22, '23-46384', 8, 2, 'FIRST', '2024-2025'),
(45, 34, 24, '23-46384', 8, 2, 'FIRST', '2024-2025'),
(46, 37, 8, '23-46384', 8, 2, 'FIRST', '2024-2025'),
(47, 35, 19, '23-46384', 8, 2, 'FIRST', '2024-2025'),
(48, 38, 21, '23-46384', 8, 2, 'FIRST', '2024-2025'),
(49, 57, 1, '22-46378', 30, 2, 'FIRST', '2024-2025'),
(50, 58, 1, '22-46378', 30, 2, 'FIRST', '2024-2025'),
(51, 20, 5, '22-46378', 30, 2, 'FIRST', '2024-2025'),
(52, 24, 8, '22-46378', 31, 2, 'FIRST', '2024-2025'),
(53, 21, 10, '22-46378', 31, 2, 'FIRST', '2024-2025'),
(54, 23, 11, '22-46378', 31, 2, 'FIRST', '2024-2025'),
(55, 57, 1, '22-46379', 30, 2, 'FIRST', '2024-2025'),
(56, 58, 1, '22-46379', 30, 2, 'FIRST', '2024-2025'),
(57, 20, 5, '22-46379', 30, 2, 'FIRST', '2024-2025'),
(58, 24, 8, '22-46379', 31, 2, 'FIRST', '2024-2025'),
(59, 21, 10, '22-46379', 31, 2, 'FIRST', '2024-2025'),
(60, 23, 11, '22-46379', 31, 2, 'FIRST', '2024-2025'),
(61, 57, 1, '22-46380', 30, 2, 'FIRST', '2024-2025'),
(62, 58, 1, '22-46380', 30, 2, 'FIRST', '2024-2025'),
(63, 20, 5, '22-46380', 30, 2, 'FIRST', '2024-2025'),
(64, 24, 8, '22-46380', 31, 2, 'FIRST', '2024-2025'),
(65, 21, 10, '22-46380', 31, 2, 'FIRST', '2024-2025'),
(66, 23, 11, '22-46380', 31, 2, 'FIRST', '2024-2025'),
(67, 57, 1, '22-46381', 30, 2, 'FIRST', '2024-2025'),
(68, 58, 1, '22-46381', 30, 2, 'FIRST', '2024-2025'),
(69, 20, 5, '22-46381', 30, 2, 'FIRST', '2024-2025'),
(70, 24, 8, '22-46381', 31, 2, 'FIRST', '2024-2025'),
(71, 21, 10, '22-46381', 31, 2, 'FIRST', '2024-2025'),
(72, 23, 11, '22-46381', 31, 2, 'FIRST', '2024-2025'),
(73, 58, 1, '22-46394', 32, 2, 'FIRST', '2024-2025'),
(74, 58, 1, '22-46397', 32, 2, 'FIRST', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `day_id` int(11) NOT NULL,
  `days` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`day_id`, `days`) VALUES
(1, 'Monday'),
(2, 'Tuesday'),
(3, 'Wednesday'),
(4, 'Thursday'),
(5, 'Friday'),
(6, 'Saturday'),
(7, 'Sunday');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_student`
--

CREATE TABLE `enrolled_student` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `sr_code` varchar(30) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_status` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolled_student`
--

INSERT INTO `enrolled_student` (`id`, `subject_id`, `sr_code`, `section_id`, `subject_status`, `semester`, `academic_year`) VALUES
(67, 36, '23-46378', 8, 0, 'FIRST', '2024-2025'),
(68, 40, '23-46378', 8, 0, 'FIRST', '2024-2025'),
(69, 39, '23-46378', 8, 0, 'FIRST', '2024-2025'),
(70, 34, '23-46378', 8, 0, 'FIRST', '2024-2025'),
(71, 37, '23-46378', 8, 0, 'FIRST', '2024-2025'),
(72, 35, '23-46378', 8, 0, 'FIRST', '2024-2025'),
(73, 38, '23-46378', 8, 0, 'FIRST', '2024-2025'),
(74, 36, '23-46379', 8, 0, 'FIRST', '2024-2025'),
(75, 40, '23-46379', 8, 0, 'FIRST', '2024-2025'),
(76, 39, '23-46379', 8, 0, 'FIRST', '2024-2025'),
(77, 34, '23-46379', 8, 0, 'FIRST', '2024-2025'),
(78, 37, '23-46379', 8, 0, 'FIRST', '2024-2025'),
(79, 35, '23-46379', 8, 0, 'FIRST', '2024-2025'),
(80, 38, '23-46379', 8, 0, 'FIRST', '2024-2025'),
(81, 36, '23-46380', 8, 0, 'FIRST', '2024-2025'),
(82, 40, '23-46380', 8, 0, 'FIRST', '2024-2025'),
(83, 39, '23-46380', 8, 0, 'FIRST', '2024-2025'),
(84, 34, '23-46380', 8, 0, 'FIRST', '2024-2025'),
(85, 37, '23-46380', 8, 0, 'FIRST', '2024-2025'),
(86, 35, '23-46380', 8, 0, 'FIRST', '2024-2025'),
(87, 38, '23-46380', 8, 0, 'FIRST', '2024-2025'),
(88, 36, '23-46382', 8, 0, 'FIRST', '2024-2025'),
(89, 40, '23-46382', 8, 0, 'FIRST', '2024-2025'),
(90, 39, '23-46382', 8, 0, 'FIRST', '2024-2025'),
(91, 34, '23-46382', 8, 0, 'FIRST', '2024-2025'),
(92, 37, '23-46382', 8, 0, 'FIRST', '2024-2025'),
(93, 35, '23-46382', 8, 0, 'FIRST', '2024-2025'),
(94, 38, '23-46382', 8, 0, 'FIRST', '2024-2025'),
(95, 36, '23-46384', 8, 0, 'FIRST', '2024-2025'),
(96, 40, '23-46384', 8, 0, 'FIRST', '2024-2025'),
(97, 39, '23-46384', 8, 0, 'FIRST', '2024-2025'),
(98, 34, '23-46384', 8, 0, 'FIRST', '2024-2025'),
(99, 37, '23-46384', 8, 0, 'FIRST', '2024-2025'),
(100, 35, '23-46384', 8, 0, 'FIRST', '2024-2025'),
(101, 38, '23-46384', 8, 0, 'FIRST', '2024-2025'),
(102, 57, '19-63308', 30, 0, 'FIRST', '2024-2025'),
(103, 58, '19-63308', 30, 0, 'FIRST', '2024-2025'),
(104, 20, '19-63308', 30, 0, 'FIRST', '2024-2025'),
(105, 57, '22-46378', 30, 0, 'FIRST', '2024-2025'),
(106, 58, '22-46378', 30, 0, 'FIRST', '2024-2025'),
(107, 20, '22-46378', 30, 0, 'FIRST', '2024-2025'),
(108, 24, '22-46378', 31, 0, 'FIRST', '2024-2025'),
(109, 21, '22-46378', 31, 0, 'FIRST', '2024-2025'),
(110, 23, '22-46378', 31, 0, 'FIRST', '2024-2025'),
(111, 57, '22-46379', 30, 0, 'FIRST', '2024-2025'),
(112, 58, '22-46379', 30, 0, 'FIRST', '2024-2025'),
(113, 20, '22-46379', 30, 0, 'FIRST', '2024-2025'),
(114, 24, '22-46379', 31, 0, 'FIRST', '2024-2025'),
(115, 23, '22-46379', 31, 0, 'FIRST', '2024-2025'),
(116, 21, '22-46379', 31, 0, 'FIRST', '2024-2025'),
(117, 57, '22-46380', 30, 0, 'FIRST', '2024-2025'),
(118, 58, '22-46380', 30, 0, 'FIRST', '2024-2025'),
(119, 20, '22-46380', 30, 0, 'FIRST', '2024-2025'),
(120, 24, '22-46380', 31, 0, 'FIRST', '2024-2025'),
(121, 23, '22-46380', 31, 0, 'FIRST', '2024-2025'),
(122, 21, '22-46380', 31, 0, 'FIRST', '2024-2025'),
(123, 57, '22-46381', 30, 0, 'FIRST', '2024-2025'),
(124, 58, '22-46381', 30, 0, 'FIRST', '2024-2025'),
(125, 20, '22-46381', 30, 0, 'FIRST', '2024-2025'),
(126, 24, '22-46381', 31, 0, 'FIRST', '2024-2025'),
(127, 23, '22-46381', 31, 0, 'FIRST', '2024-2025'),
(128, 21, '22-46381', 31, 0, 'FIRST', '2024-2025'),
(129, 24, '22-46382', 31, 0, 'FIRST', '2024-2025'),
(130, 4, '24-46378', 2, 0, 'FIRST', '2024-2025'),
(131, 57, '22-46394', 30, 0, 'FIRST', '2024-2025'),
(132, 57, '22-46391', 30, 0, 'FIRST', '2024-2025'),
(133, 58, '22-46391', 31, 0, 'FIRST', '2024-2025'),
(134, 20, '22-46391', 30, 0, 'FIRST', '2024-2025'),
(135, 24, '22-46391', 31, 0, 'FIRST', '2024-2025'),
(136, 23, '22-46391', 31, 0, 'FIRST', '2024-2025'),
(137, 21, '22-46391', 31, 0, 'FIRST', '2024-2025'),
(138, 36, '22-01234', 8, 0, 'FIRST', '2024-2025'),
(139, 58, '22-46394', 32, 0, 'FIRST', '2024-2025'),
(140, 20, '22-46394', 30, 0, 'FIRST', '2024-2025'),
(141, 58, '22-46397', 32, 0, 'FIRST', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_subject`
--

CREATE TABLE `enrolled_subject` (
  `id` int(11) NOT NULL,
  `subject_id` varchar(100) NOT NULL,
  `sr_code` varchar(30) NOT NULL,
  `section_id` varchar(50) NOT NULL,
  `faculty_id` varchar(11) NOT NULL,
  `subject_status` varchar(11) NOT NULL DEFAULT '1',
  `eval_status` int(11) DEFAULT NULL,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolled_subject`
--

INSERT INTO `enrolled_subject` (`id`, `subject_id`, `sr_code`, `section_id`, `faculty_id`, `subject_status`, `eval_status`, `semester`, `academic_year`) VALUES
(36, 'Computer Networking 1', '23-46378', 'IT-2102', '6', '1', 1, 'FIRST', '2024-2025'),
(37, 'Object-Oriented Programming', '23-46378', 'IT-2102', '23', '1', 1, 'FIRST', '2024-2025'),
(38, 'Individual and Dual Sports', '23-46378', 'IT-2102', '22', '1', 1, 'FIRST', '2024-2025'),
(39, 'ASEAN Literature', '23-46378', 'IT-2102', '24', '1', 1, 'FIRST', '2024-2025'),
(40, 'Database Management System', '23-46378', 'IT-2102', '8', '1', 1, 'FIRST', '2024-2025'),
(41, 'Calculus-Based Physics', '23-46378', 'IT-2102', '19', '1', 1, 'FIRST', '2024-2025'),
(42, 'Discrete Mathematics', '23-46378', 'IT-2102', '21', '1', 1, 'FIRST', '2024-2025'),
(43, 'Computer Networking 1', '23-46379', 'IT-2102', '6', '1', 1, 'FIRST', '2024-2025'),
(44, 'Object-Oriented Programming', '23-46379', 'IT-2102', '23', '1', 1, 'FIRST', '2024-2025'),
(45, 'Individual and Dual Sports', '23-46379', 'IT-2102', '22', '1', 1, 'FIRST', '2024-2025'),
(46, 'ASEAN Literature', '23-46379', 'IT-2102', '24', '1', 1, 'FIRST', '2024-2025'),
(47, 'Database Management System', '23-46379', 'IT-2102', '8', '1', 1, 'FIRST', '2024-2025'),
(48, 'Calculus-Based Physics', '23-46379', 'IT-2102', '19', '1', 1, 'FIRST', '2024-2025'),
(49, 'Discrete Mathematics', '23-46379', 'IT-2102', '21', '1', 1, 'FIRST', '2024-2025'),
(50, 'Computer Networking 1', '23-46380', 'IT-2102', '6', '1', 1, 'FIRST', '2024-2025'),
(51, 'Object-Oriented Programming', '23-46380', 'IT-2102', '23', '1', 1, 'FIRST', '2024-2025'),
(52, 'Individual and Dual Sports', '23-46380', 'IT-2102', '22', '1', 1, 'FIRST', '2024-2025'),
(53, 'ASEAN Literature', '23-46380', 'IT-2102', '24', '1', 1, 'FIRST', '2024-2025'),
(54, 'Database Management System', '23-46380', 'IT-2102', '8', '1', 1, 'FIRST', '2024-2025'),
(55, 'Calculus-Based Physics', '23-46380', 'IT-2102', '19', '1', 1, 'FIRST', '2024-2025'),
(56, 'Discrete Mathematics', '23-46380', 'IT-2102', '21', '1', 1, 'FIRST', '2024-2025'),
(57, 'Computer Networking 1', '23-46382', 'IT-2102', '6', '1', 1, 'FIRST', '2024-2025'),
(58, 'Object-Oriented Programming', '23-46382', 'IT-2102', '23', '1', 1, 'FIRST', '2024-2025'),
(59, 'Individual and Dual Sports', '23-46382', 'IT-2102', '22', '1', 1, 'FIRST', '2024-2025'),
(60, 'ASEAN Literature', '23-46382', 'IT-2102', '24', '1', 1, 'FIRST', '2024-2025'),
(61, 'Database Management System', '23-46382', 'IT-2102', '8', '1', 1, 'FIRST', '2024-2025'),
(62, 'Calculus-Based Physics', '23-46382', 'IT-2102', '19', '1', 1, 'FIRST', '2024-2025'),
(63, 'Discrete Mathematics', '23-46382', 'IT-2102', '21', '1', 1, 'FIRST', '2024-2025'),
(64, 'Computer Networking 1', '23-46384', 'IT-2102', '6', '1', 1, 'FIRST', '2024-2025'),
(65, 'Object-Oriented Programming', '23-46384', 'IT-2102', '23', '1', 1, 'FIRST', '2024-2025'),
(66, 'Individual and Dual Sports', '23-46384', 'IT-2102', '22', '1', 1, 'FIRST', '2024-2025'),
(67, 'ASEAN Literature', '23-46384', 'IT-2102', '24', '1', 1, 'FIRST', '2024-2025'),
(68, 'Database Management System', '23-46384', 'IT-2102', '8', '1', 1, 'FIRST', '2024-2025'),
(69, 'Calculus-Based Physics', '23-46384', 'IT-2102', '19', '1', 1, 'FIRST', '2024-2025'),
(70, 'Discrete Mathematics', '23-46384', 'IT-2102', '21', '1', 1, 'FIRST', '2024-2025'),
(71, 'Fundamentals of Business Analytics ', '19-63308', 'ITBA-3101', '1', '1', NULL, 'FIRST', '2024-2025'),
(72, 'Fundamentals of Analytics Modeling ', '19-63308', 'ITBA-3101', '1', '1', NULL, 'FIRST', '2024-2025'),
(73, 'Ethics', '19-63308', 'ITBA-3101', '5', '1', NULL, 'FIRST', '2024-2025'),
(74, 'Fundamentals of Business Analytics ', '22-46378', 'ITBA-3101', '1', '1', 1, 'FIRST', '2024-2025'),
(75, 'Fundamentals of Analytics Modeling ', '22-46378', 'ITBA-3101', '1', '1', 1, 'FIRST', '2024-2025'),
(76, 'Ethics', '22-46378', 'ITBA-3101', '5', '1', 1, 'FIRST', '2024-2025'),
(77, 'Web Systems and Technologies', '22-46378', 'ITBA-3102', '8', '1', 1, 'FIRST', '2024-2025'),
(78, 'System Analysis and Design', '22-46378', 'ITBA-3102', '10', '1', 1, 'FIRST', '2024-2025'),
(79, 'Systems Integration and Architecture', '22-46378', 'ITBA-3102', '11', '1', 1, 'FIRST', '2024-2025'),
(80, 'Fundamentals of Business Analytics ', '22-46379', 'ITBA-3101', '1', '1', 1, 'FIRST', '2024-2025'),
(81, 'Fundamentals of Analytics Modeling ', '22-46379', 'ITBA-3101', '1', '1', 1, 'FIRST', '2024-2025'),
(82, 'Ethics', '22-46379', 'ITBA-3101', '5', '1', 1, 'FIRST', '2024-2025'),
(83, 'Web Systems and Technologies', '22-46379', 'ITBA-3102', '8', '1', 1, 'FIRST', '2024-2025'),
(84, 'Systems Integration and Architecture', '22-46379', 'ITBA-3102', '11', '1', 1, 'FIRST', '2024-2025'),
(85, 'System Analysis and Design', '22-46379', 'ITBA-3102', '10', '1', 1, 'FIRST', '2024-2025'),
(86, 'Fundamentals of Business Analytics ', '22-46380', 'ITBA-3101', '1', '1', 1, 'FIRST', '2024-2025'),
(87, 'Fundamentals of Analytics Modeling ', '22-46380', 'ITBA-3101', '1', '1', 1, 'FIRST', '2024-2025'),
(88, 'Ethics', '22-46380', 'ITBA-3101', '5', '1', 1, 'FIRST', '2024-2025'),
(89, 'Web Systems and Technologies', '22-46380', 'ITBA-3102', '8', '1', 1, 'FIRST', '2024-2025'),
(90, 'Systems Integration and Architecture', '22-46380', 'ITBA-3102', '11', '1', 1, 'FIRST', '2024-2025'),
(91, 'System Analysis and Design', '22-46380', 'ITBA-3102', '10', '1', 1, 'FIRST', '2024-2025'),
(92, 'Fundamentals of Business Analytics ', '22-46381', 'ITBA-3101', '1', '1', 1, 'FIRST', '2024-2025'),
(93, 'Fundamentals of Analytics Modeling ', '22-46381', 'ITBA-3101', '1', '1', 1, 'FIRST', '2024-2025'),
(94, 'Ethics', '22-46381', 'ITBA-3101', '5', '1', 1, 'FIRST', '2024-2025'),
(95, 'Web Systems and Technologies', '22-46381', 'ITBA-3102', '8', '1', 1, 'FIRST', '2024-2025'),
(96, 'Systems Integration and Architecture', '22-46381', 'ITBA-3102', '11', '1', 1, 'FIRST', '2024-2025'),
(97, 'System Analysis and Design', '22-46381', 'ITBA-3102', '10', '1', 1, 'FIRST', '2024-2025'),
(98, 'Web Systems and Technologies', '22-46382', 'ITBA-3102', '8', '1', NULL, 'FIRST', '2024-2025'),
(99, 'Introduction to Computing', '24-46378', 'IT-1102', '9', '1', NULL, 'FIRST', '2024-2025'),
(100, 'Fundamentals of Business Analytics ', '22-46394', 'ITBA-3101', '1', '1', NULL, 'FIRST', '2024-2025'),
(101, 'Fundamentals of Business Analytics ', '22-46391', 'ITBA-3101', '1', '1', NULL, 'FIRST', '2024-2025'),
(102, 'Fundamentals of Analytics Modeling ', '22-46391', 'ITBA-3102', '7', '1', NULL, 'FIRST', '2024-2025'),
(103, 'Ethics', '22-46391', 'ITBA-3101', '5', '1', NULL, 'FIRST', '2024-2025'),
(104, 'Web Systems and Technologies', '22-46391', 'ITBA-3102', '8', '1', NULL, 'FIRST', '2024-2025'),
(105, 'Systems Integration and Architecture', '22-46391', 'ITBA-3102', '11', '1', NULL, 'FIRST', '2024-2025'),
(106, 'System Analysis and Design', '22-46391', 'ITBA-3102', '10', '1', NULL, 'FIRST', '2024-2025'),
(107, 'Computer Networking 1', '22-01234', 'IT-2102', '6', '1', NULL, 'FIRST', '2024-2025'),
(108, 'Fundamentals of Analytics Modeling ', '22-46394', 'ITBA-3103', '1', '1', 1, 'FIRST', '2024-2025'),
(109, 'Ethics', '22-46394', 'ITBA-3101', '5', '1', NULL, 'FIRST', '2024-2025'),
(110, 'Fundamentals of Analytics Modeling ', '22-46397', 'ITBA-3103', '1', '1', 1, 'FIRST', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `facultycategories`
--

CREATE TABLE `facultycategories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `linkOne` text NOT NULL,
  `linkTwo` text NOT NULL,
  `linkThree` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facultycategories`
--

INSERT INTO `facultycategories` (`id`, `categories`, `linkOne`, `linkTwo`, `linkThree`) VALUES
(1, 'PROFESSIONALISM', 'https://uk.indeed.com/career-advice/career-development/professionalism', 'https://pollackpeacebuilding.com/blog/professionalism-in-the-workplace', 'https://www.coursera.org/specializations/professional-skills-for-the-workplace'),
(2, 'INTERPERSONAL BEHAVIOR', 'https://blog.empuls.io/interpersonal-skills', 'https://www.coursera.org/learn/interpersonal-skills', 'https://www.coursera.org/learn/wharton-communication-skills'),
(5, 'WORK HABITS', 'https://www.forbes.com/councils/theyec/2022/07/25/nine-work-habits-that-can-improve-your-productivity-and-focus', 'https://www.coursera.org/learn/problem-solving///https://healthyofficehabits.com/work-habits', 'https://www.coursera.org/specializations/effective-communication'),
(6, 'TEAMWORK', 'https://www.glassdoor.com/blog/guide/teamwork-skills', 'https://www.coursera.org/learn/teamwork-skills-effective-communication', 'https://www.michaelpage.com.au/advice/career-advice/productivity-and-performance/5-vital-skills-successful-teamwork');

-- --------------------------------------------------------

--
-- Table structure for table `facultycriteria`
--

CREATE TABLE `facultycriteria` (
  `id` int(11) NOT NULL,
  `facultyCategories` text NOT NULL,
  `facultyCriteria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facultycriteria`
--

INSERT INTO `facultycriteria` (`id`, `facultyCategories`, `facultyCriteria`) VALUES
(27, 'PROFESSIONALISM', 'Consistently adheres to professional standards in behavior, dress, and communication, setting a positive example for colleagues and students.'),
(28, 'PROFESSIONALISM', 'Demonstrates integrity in all professional interactions, ensuring that actions align with the ethical standards of the institution.'),
(29, 'PROFESSIONALISM', 'Manages time effectively by meeting deadlines, being punctual to meetings, and responding to communication in a timely manner.'),
(30, 'PROFESSIONALISM', 'Upholds the institution’s policies and procedures, and encourages others to do the same, contributing to a respectful and orderly work environment.'),
(31, 'PROFESSIONALISM', 'Provides constructive feedback to colleagues in a respectful manner, aiming to help them improve their professional practice.'),
(33, 'INTERPERSONAL BEHAVIOR', 'Interacts with colleagues in a respectful and supportive manner, fostering a warm atmosphere where all members feel valued and appreciated.'),
(34, 'INTERPERSONAL BEHAVIOR', 'Listens actively during conversations, showing genuine interest in the perspectives of others and responding thoughtfully.'),
(35, 'INTERPERSONAL BEHAVIOR', 'Demonstrates empathy and understanding in interactions, especially during discussions of sensitive or challenging topics.'),
(36, 'INTERPERSONAL BEHAVIOR', 'Provides encouragement and support to colleagues, helping to build their confidence and motivate them to succeed.'),
(37, 'INTERPERSONAL BEHAVIOR', 'Maintains positive relationships with all colleagues, even when there are differences of opinion or approach.'),
(38, 'WORK HABITS', 'Displays a strong work ethic by consistently meeting deadlines, producing high-quality work, and taking initiative in tasks and projects.'),
(39, 'WORK HABITS', 'Prioritizes tasks effectively, managing time and resources to ensure that all responsibilities are fulfilled to a high standard.'),
(40, 'WORK HABITS', 'Demonstrates reliability by following through on commitments and being dependable in completing assigned duties.'),
(41, 'WORK HABITS', 'Maintains a high level of organization in managing tasks, documentation, and communication, ensuring that all work is completed efficiently.'),
(42, 'WORK HABITS', 'Adapts to changes in work assignments or schedules with a positive attitude and a willingness to adjust as needed.'),
(43, 'TEAMWORK', 'Demonstrates a strong commitment to collaborative work and consistently contributes valuable ideas during team meetings and discussions.'),
(44, 'TEAMWORK', 'Works effectively with colleagues by actively participating in group tasks, showing respect for diverse perspectives, and supporting team decisions.'),
(45, 'TEAMWORK', 'Takes on an equitable share of the workload in group projects and assists team members when needed to ensure project success.'),
(46, 'TEAMWORK', 'Maintains open lines of communication with colleagues, fostering a collaborative environment where information and resources are shared freely.'),
(47, 'TEAMWORK', 'Addresses conflicts within the team constructively, seeking to resolve issues through dialogue and compromise.'),
(48, 'PROFESSIONALISM', 'Remains composed and professional in challenging situations, maintaining a calm attitude and making decisions based on sound judgment.');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_averages`
--

CREATE TABLE `faculty_averages` (
  `id` int(11) NOT NULL,
  `faculty_Id` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `combined_average` varchar(255) NOT NULL,
  `average` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_averages`
--

INSERT INTO `faculty_averages` (`id`, `faculty_Id`, `subject`, `semester`, `academic_year`, `combined_average`, `average`) VALUES
(71, '1', 'Capstone Project 2', 'FIRST', '2024-2025', '0', 0),
(72, '1', 'Platform Technologies', 'FIRST', '2024-2025', '0', 0),
(73, '1', 'Fundamentals of Business Analytics ', 'FIRST', '2024-2025', '1.835', 0),
(74, '1', 'Fundamentals of Analytics Modeling ', 'FIRST', '2024-2025', '1.865', 0),
(75, '6', 'Computer Networking 1', 'FIRST', '2024-2025', '1.935', 0),
(76, '23', 'Object-Oriented Programming', 'FIRST', '2024-2025', '1.84', 0),
(77, '2', 'Social Issues and Professional Practice', 'FIRST', '2024-2025', '0', 0),
(78, '2', 'Computer Networking 3', 'FIRST', '2024-2025', '0', 0),
(79, '2', 'Internet of Things (IoT)', 'FIRST', '2024-2025', '0', 0),
(80, '3', 'Principles of System Thinking', 'FIRST', '2024-2025', '0', 0),
(81, '3', 'Computer Programming', 'FIRST', '2024-2025', '0', 0),
(82, '5', 'Technopreneurship', 'FIRST', '2024-2025', '0', 0),
(83, '5', 'Fundamentals of Business Process Outsourcing 101 ', 'FIRST', '2024-2025', '0', 0),
(84, '5', 'Ethics', 'FIRST', '2024-2025', '0', 0),
(85, '4', 'Advanced Information Assurance and Security', 'FIRST', '2024-2025', '0', 0),
(86, '8', 'Database Management System', 'FIRST', '2024-2025', '1.705', 0),
(87, '11', 'Kontekstwalisadong Komunikasyon sa Filipino', 'FIRST', '2024-2025', '0', 0),
(88, '11', 'Filipino sa Ibat-ibang Disiplina', 'FIRST', '2024-2025', '0', 0),
(89, '12', 'Business Communication', 'FIRST', '2024-2025', '0', 0),
(90, '12', 'Introduction to Computing', 'FIRST', '2024-2025', '0', 0),
(91, '13', 'Art Appreciation', 'FIRST', '2024-2025', '0', 0),
(92, '19', 'Calculus-Based Physics', 'FIRST', '2024-2025', '1.855', 0),
(93, '21', 'Discrete Mathematics', 'FIRST', '2024-2025', '1.895', 0),
(94, '22', 'Individual and Dual Sports', 'FIRST', '2024-2025', '1.815', 0),
(95, '24', 'ASEAN Literature', 'FIRST', '2024-2025', '1.85', 0),
(96, '25', 'Advanced Computer Programming', 'FIRST', '2024-2025', '0', 0),
(97, '7', 'Fundamentals of Business Analytics ', 'FIRST', '2024-2025', '0', 0),
(98, '7', 'Fundamentals of Analytics Modeling ', 'FIRST', '2024-2025', '0', 0),
(99, '8', 'Web Systems and Technologies', 'FIRST', '2024-2025', '1.93', 0);

-- --------------------------------------------------------

--
-- Table structure for table `failed_subject`
--

CREATE TABLE `failed_subject` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `sr_code` varchar(30) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_status` int(11) NOT NULL,
  `sem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `faculty_Id` int(11) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `gsuite` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`faculty_Id`, `usertype`, `first_name`, `last_name`, `image`, `gsuite`, `password`, `status`) VALUES
(1, 'admin', 'Shiela Marie', 'Garcia', '../public/picture/facultyMembers/670cc57746f15-202409261727329342.jpg', 'shielamarie.garcia@g.batstate-u.edu.ph', 'sss', 1),
(2, 'admin', 'Johnrey', 'Manzanal', '../public/picture/facultyMembers/202409261727329186.jpg', 'johnrey.manzanal@g.batstate-u.edu.ph', 'MANZANAL', 1),
(3, 'admin', 'Joseph Rizalde', 'Guillo', '../public/picture/facultyMembers/202409261727329212.jpg', 'josephrizalde.guillo@g.batstate-u.edu.ph', 'GUILLO', 1),
(4, 'faculty', 'Donna', 'Garcia', '../public/picture/facultyMembers/202409261727329239.jpg', 'donna.garcia@g.batstate-u.edu.ph', 'GARCIA', 1),
(5, 'faculty', 'Eddie Jr.', 'Bucad', '../public/picture/facultyMembers/202409261727329256.jpg', 'eddiejr.bucad@g.batstate-u.edu.ph', 'BUCAD', 1),
(6, 'faculty', 'Erwin', 'De Castro', '../public/picture/facultyMembers/202409261727329275.jpg', 'erwin.decastro@g.batstate-u.edu.ph', 'DE CASTRO', 1),
(7, 'faculty', 'Miguel Edward', 'Rosal', '../public/picture/facultyMembers/202409261727329294.jpg', 'migueledward.rosal@g.batstate-u.edu.ph', 'ROSAL', 1),
(8, 'faculty', 'Mary Jean', 'Abejuela', '../public/picture/facultyMembers/202409261727329310.jpg', 'maryjean.abejuela@g.batstate-u.edu.ph', 'ABEJUELA', 1),
(9, 'faculty', 'Melvin', 'Babol', '../public/picture/facultyMembers/202409261727329328.jpg', 'melvin.babol@g.batstate-u.edu.ph', 'BABOL', 1),
(10, 'faculty', 'Menard', 'Canoy', '../public/picture/facultyMembers/202409261727329342.jpg', 'menard.canoy@g.batstate-u.edu.ph', 'CANOY', 1),
(11, 'faculty', 'Cruzette', 'Calzo', '../public/picture/facultyMembers/202409261727329370.jpg', 'cruzette.calzo@g.batstate-u.edu.ph', 'CALZO', 1),
(12, 'faculty', 'Nino', 'Eusebio', '../public/picture/facultyMembers/202409261727329392.jpg', 'nino.eusebio@g.batstate-u.edu.ph', 'EUSEBIO', 1),
(13, 'faculty', 'Val Juniel', 'Biscocho', '../public/picture/facultyMembers/202409261727329411.jpg', 'valjuniel.biscocho@g.batstate-u.edu.ph', 'aaa', 1),
(19, 'faculty', 'Jasmin', 'Pesigan', '../public/picture/facultyMembers/202411221732253713.jpg', 'jasmin.pesigan@g.batstate-u.edu.ph', 'PESIGAN', 1),
(20, 'faculty', 'Ronald', 'Tud', '../public/picture/facultyMembers/202411221732253735.jpg', 'ronald.tud@g.batstate-u.edu.ph', 'TUD', 1),
(21, 'faculty', 'Ariane', 'Villanueva', '../public/picture/facultyMembers/202411221732253755.jpg', 'ariane.villanueva@g.batstate-u.edu.ph', 'VILLANUEVA', 1),
(22, 'faculty', 'Bryan', 'Mondres', '../public/picture/facultyMembers/202411221732253774.jpg', 'bryan.mondres@g.batstate-u.edu.ph', 'MONDRES', 1),
(23, 'faculty', 'Michael', 'Ramilo', '../public/picture/facultyMembers/202411221732253999.jpg', 'michael.ramilo@g.batstate-u.edu.ph', 'RAMILO', 1),
(24, 'faculty', 'Hazel Joy', 'Banayo', '../public/picture/facultyMembers/202411221732254023.jpg', 'hazeljoy.banayo@g.batstate-u.edu.ph', 'BANAYO', 1),
(25, 'faculty', 'Noel', 'Virrey', '../public/picture/facultyMembers/202411221732254055.jpg', 'noel.virrey@g.batstate-u.edu.ph', 'VIRREY', 1),
(26, 'faculty', 'try', 'try', '../public/picture/facultyMembers/202411231732376975.jpg', 'try.try@g.batstate-u.edu.ph', 'TRY', 0);

-- --------------------------------------------------------

--
-- Table structure for table `peertopeerform`
--

CREATE TABLE `peertopeerform` (
  `id` int(11) NOT NULL,
  `toFacultyID` int(11) NOT NULL,
  `fromFacultyID` int(11) NOT NULL,
  `toFaculty` varchar(255) NOT NULL,
  `fromFaculty` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `commentText` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `doneStatus` int(11) NOT NULL,
  `PROFESSIONALISM27` varchar(255) DEFAULT NULL,
  `PROFESSIONALISM28` varchar(255) DEFAULT NULL,
  `PROFESSIONALISM29` varchar(255) DEFAULT NULL,
  `PROFESSIONALISM30` varchar(255) DEFAULT NULL,
  `PROFESSIONALISM31` varchar(255) DEFAULT NULL,
  `INTERPERSONALBEHAVIOR33` varchar(255) DEFAULT NULL,
  `INTERPERSONALBEHAVIOR34` varchar(255) DEFAULT NULL,
  `INTERPERSONALBEHAVIOR35` varchar(255) DEFAULT NULL,
  `INTERPERSONALBEHAVIOR36` varchar(255) DEFAULT NULL,
  `INTERPERSONALBEHAVIOR37` varchar(255) DEFAULT NULL,
  `WORKHABITS38` varchar(255) DEFAULT NULL,
  `WORKHABITS39` varchar(255) DEFAULT NULL,
  `WORKHABITS40` varchar(255) DEFAULT NULL,
  `WORKHABITS41` varchar(255) DEFAULT NULL,
  `WORKHABITS42` varchar(255) DEFAULT NULL,
  `TEAMWORK43` varchar(255) DEFAULT NULL,
  `TEAMWORK44` varchar(255) DEFAULT NULL,
  `TEAMWORK45` varchar(255) DEFAULT NULL,
  `TEAMWORK46` varchar(255) DEFAULT NULL,
  `TEAMWORK47` varchar(255) DEFAULT NULL,
  `PROFESSIONALISM48` varchar(255) DEFAULT NULL,
  `INTERPERSONALBEHAVIOR59` varchar(255) DEFAULT NULL,
  `WORKHABITS61` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peertopeerform`
--

INSERT INTO `peertopeerform` (`id`, `toFacultyID`, `fromFacultyID`, `toFaculty`, `fromFaculty`, `semester`, `academic_year`, `commentText`, `date`, `doneStatus`, `PROFESSIONALISM27`, `PROFESSIONALISM28`, `PROFESSIONALISM29`, `PROFESSIONALISM30`, `PROFESSIONALISM31`, `INTERPERSONALBEHAVIOR33`, `INTERPERSONALBEHAVIOR34`, `INTERPERSONALBEHAVIOR35`, `INTERPERSONALBEHAVIOR36`, `INTERPERSONALBEHAVIOR37`, `WORKHABITS38`, `WORKHABITS39`, `WORKHABITS40`, `WORKHABITS41`, `WORKHABITS42`, `TEAMWORK43`, `TEAMWORK44`, `TEAMWORK45`, `TEAMWORK46`, `TEAMWORK47`, `PROFESSIONALISM48`, `INTERPERSONALBEHAVIOR59`, `WORKHABITS61`) VALUES
(32, 6, 1, 'Erwin De Castro', 'Shiela Marie Garcia', 'FIRST', '2024-2025', 'Nam nec eleifend magna. Fusce sollicitudin vitae metus nec tristique.', '2024-11-22', 1, '2', '3', '4', '5', '4', '3', '4', '4', '4', '4', '4', '3', '4', '5', '4', '5', '4', '3', '4', '5', '3', NULL, NULL),
(33, 25, 1, 'Noel Virrey', 'Shiela Marie Garcia', 'FIRST', '2024-2025', 'Nam nec eleifend magna. Fusce sollicitudin vitae metus nec tristique.', '2024-11-22', 1, '3', '4', '5', '4', '3', '5', '4', '3', '4', '5', '3', '4', '5', '4', '3', '4', '5', '4', '4', '5', '3', NULL, NULL),
(34, 7, 1, 'Miguel Edward Rosal', 'Shiela Marie Garcia', 'FIRST', '2024-2025', 'Quisque aliquet consectetur lectus vel porttitor. Sed vulputate tincidunt feugiat.', '2024-11-22', 1, '5', '4', '3', '4', '5', '4', '5', '4', '3', '2', '4', '5', '4', '4', '5', '3', '4', '5', '4', '3', '4', NULL, NULL),
(35, 21, 1, 'Ariane Villanueva', 'Shiela Marie Garcia', 'FIRST', '2024-2025', 'Curabitur mattis, diam sed aliquam placerat, nulla felis egestas lacus, sed pellentesque nibh leo eu ipsum.', '2024-11-22', 1, '3', '4', '5', '4', '3', '2', '4', '3', '4', '5', '4', '5', '4', '3', '3', '3', '4', '5', '4', '5', '4', NULL, NULL),
(36, 10, 2, 'Menard Canoy', 'Johnrey Manzanal', 'FIRST', '2024-2025', 'Donec accumsan ante scelerisque lobortis tristique. Cras pretium nisl arcu, eu vehicula enim ullamcorper ac. Sed nec accumsan diam.', '2024-11-22', 1, '3', '4', '5', '4', '5', '3', '4', '5', '4', '3', '4', '4', '4', '5', '3', '4', '4', '5', '4', '5', '4', NULL, NULL),
(37, 12, 2, 'Nino Eusebio', 'Johnrey Manzanal', 'FIRST', '2024-2025', 'Vestibulum convallis, mi id hendrerit venenatis, erat magna congue quam, quis ultrices sem ex a mi.', '2024-11-22', 1, '5', '4', '5', '4', '5', '4', '3', '2', '3', '4', '4', '5', '4', '3', '3', '5', '5', '4', '5', '4', '4', NULL, NULL),
(38, 25, 2, 'Noel Virrey', 'Johnrey Manzanal', 'FIRST', '2024-2025', 'Interdum et malesuada fames ac ante ipsum primis in faucibus. Integer scelerisque ante in ipsum faucibus, non auctor dui mattis.', '2024-11-22', 1, '5', '5', '3', '4', '3', '4', '4', '5', '4', '4', '4', '5', '4', '4', '4', '4', '4', '5', '4', '5', '5', NULL, NULL),
(39, 4, 2, 'Donna Garcia', 'Johnrey Manzanal', 'FIRST', '2024-2025', 'Fusce sit amet interdum nisi. Praesent commodo aliquet purus eget venenatis. Cras dignissim neque id magna malesuada lobortis.', '2024-11-22', 1, '2', '4', '3', '5', '4', '4', '4', '5', '4', '5', '4', '4', '5', '4', '5', '4', '4', '4', '4', '4', '4', NULL, NULL),
(40, 9, 2, 'Melvin Babol', 'Johnrey Manzanal', 'FIRST', '2024-2025', 'Fusce sit amet interdum nisi. Praesent commodo aliquet purus eget venenatis. Cras dignissim neque id magna malesuada lobortis.', '2024-11-22', 1, '5', '5', '4', '5', '4', '4', '4', '4', '4', '4', '2', '4', '4', '5', '4', '4', '4', '4', '5', '4', '5', NULL, NULL),
(41, 9, 3, 'Melvin Babol', 'Joseph Rizalde Guillo', 'FIRST', '2024-2025', 'Proin iaculis magna vitae finibus sollicitudin. Integer faucibus egestas rhoncus. Aliquam rhoncus diam a risus rhoncus egestas', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '4', '4', '4', '4', '4', '4', '5', '5', '5', '5', '1', '4', '4', '2', '5', NULL, NULL),
(42, 19, 3, 'Jasmin Pesigan', 'Joseph Rizalde Guillo', 'FIRST', '2024-2025', 'Maecenas tortor sapien, ultricies at ligula ac, efficitur cursus lectus. Sed at dolor suscipit, vestibulum sapien quis, semper dolor. Nulla eu nisl quam.', '2024-11-22', 1, '4', '5', '5', '4', '5', '2', '1', '2', '2', '2', '2', '4', '4', '4', '4', '2', '3', '4', '4', '3', '4', NULL, NULL),
(43, 4, 3, 'Donna Garcia', 'Joseph Rizalde Guillo', 'FIRST', '2024-2025', 'Duis pretium gravida sollicitudin. Nulla laoreet risus sit amet consectetur pharetra.', '2024-11-22', 1, '5', '4', '5', '4', '4', '4', '5', '4', '5', '5', '4', '3', '4', '4', '4', '5', '5', '2', '3', '3', '4', NULL, NULL),
(44, 11, 3, 'Cruzette Calzo', 'Joseph Rizalde Guillo', 'FIRST', '2024-2025', 'unc interdum in ligula ac facilisis. Cras sed lectus odio. Aliquam erat volutpat. Cras nec varius tortor. Donec et volutpat enim.', '2024-11-22', 1, '4', '3', '2', '3', '4', '5', '4', '3', '4', '5', '2', '3', '4', '3', '2', '3', '4', '5', '4', '3', '5', NULL, NULL),
(45, 2, 3, 'Johnrey Manzanal', 'Joseph Rizalde Guillo', 'FIRST', '2024-2025', 'Cras sed lectus odio. Aliquam erat volutpat. Cras nec varius tortor. Donec et volutpat enim.', '2024-11-22', 1, '2', '3', '4', '5', '3', '5', '4', '5', '4', '3', '4', '5', '4', '3', '4', '3', '4', '3', '4', '5', '5', NULL, NULL),
(46, 7, 4, 'Miguel Edward Rosal', 'Donna Garcia', 'FIRST', '2024-2025', 'In venenatis consectetur vulputate. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '2024-11-22', 1, '4', '5', '4', '5', '4', '4', '5', '4', '4', '3', '4', '5', '4', '5', '4', '4', '5', '4', '2', '3', '4', NULL, NULL),
(47, 6, 4, 'Erwin De Castro', 'Donna Garcia', 'FIRST', '2024-2025', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', '2024-11-22', 1, '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '5', '4', '4', '3', '3', '4', '5', '4', '4', '4', NULL, NULL),
(48, 5, 4, 'Eddie Jr. Bucad', 'Donna Garcia', 'FIRST', '2024-2025', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas', '2024-11-22', 1, '3', '3', '4', '4', '5', '4', '4', '4', '5', '5', '5', '4', '5', '5', '4', '4', '5', '4', '5', '5', '4', NULL, NULL),
(49, 25, 4, 'Noel Virrey', 'Donna Garcia', 'FIRST', '2024-2025', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '2024-11-22', 1, '5', '4', '5', '4', '5', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '4', '4', '5', '4', '3', '4', NULL, NULL),
(50, 10, 4, 'Menard Canoy', 'Donna Garcia', 'FIRST', '2024-2025', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '2024-11-22', 1, '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '3', '3', '3', '3', '3', '4', '4', '5', '4', '4', '4', NULL, NULL),
(51, 11, 5, 'Cruzette Calzo', 'Eddie Jr. Bucad', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', NULL, NULL),
(52, 19, 5, 'Jasmin Pesigan', 'Eddie Jr. Bucad', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '4', '5', '4', '5', '4', '4', '5', '4', '3', '4', '4', '5', '4', '5', '4', '4', '5', '4', '4', '5', '5', NULL, NULL),
(53, 20, 5, 'Ronald Tud', 'Eddie Jr. Bucad', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '4', '4', '4', '4', '5', '3', '4', '5', '5', '5', '3', '4', '5', '4', '3', '5', '4', '5', '4', '5', '5', NULL, NULL),
(54, 9, 5, 'Melvin Babol', 'Eddie Jr. Bucad', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '5', '5', '5', '5', '5', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '3', '4', '5', '4', NULL, NULL),
(55, 1, 5, 'Shiela Marie Garcia', 'Eddie Jr. Bucad', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '2', '3', '4', '5', '4', '3', '4', '4', '4', '4', '4', '4', '5', '4', '5', '4', '4', '4', '4', '4', '3', NULL, NULL),
(56, 21, 6, 'Ariane Villanueva', 'Erwin De Castro', 'FIRST', '2024-2025', 'g elit. Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum. Aliquam egestas magna nisl, ut ultrices ex condimentum quis. Phasellus placerat volutpat blandit.', '2024-11-22', 1, '3', '3', '4', '5', '4', '3', '4', '5', '4', '5', '4', '4', '5', '4', '4', '5', '4', '5', '4', '5', '3', NULL, NULL),
(57, 2, 6, 'Johnrey Manzanal', 'Erwin De Castro', 'FIRST', '2024-2025', 'Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum. Aliquam egestas magna nisl, ut ultrices ex condimentum quis. Phasellus placerat volutpat blandit.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '4', '5', '4', '5', '5', NULL, NULL),
(58, 22, 6, 'Bryan Mondres', 'Erwin De Castro', 'FIRST', '2024-2025', 'llamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum. Aliquam egestas magna nisl, ut ultrices ex condimentum quis. Phasellus placerat volutpat blandit.', '2024-11-22', 1, '5', '5', '4', '4', '5', '4', '3', '3', '4', '5', '4', '5', '5', '4', '5', '2', '3', '4', '3', '3', '4', NULL, NULL),
(59, 20, 6, 'Ronald Tud', 'Erwin De Castro', 'FIRST', '2024-2025', 'g elit. Mauris ac consectetur ex, et convallis urna. Sedultrices ex condimentum quis. Phasellus placerat volutpat blandit.', '2024-11-22', 1, '3', '4', '5', '4', '3', '5', '5', '4', '4', '4', '4', '3', '4', '5', '4', '3', '4', '5', '4', '3', '4', NULL, NULL),
(60, 13, 6, 'Val Juniel Biscocho', 'Erwin De Castro', 'FIRST', '2024-2025', ', et vestibulum quam condimentum. Aliquam egestas magna nisl, ut ultrices ex condimentum quis. Phasellus placerat volutpat blandit.', '2024-11-22', 1, '3', '4', '5', '4', '3', '3', '5', '4', '3', '2', '3', '4', '5', '4', '3', '3', '4', '5', '4', '5', '4', NULL, NULL),
(61, 24, 7, 'Hazel Joy Banayo', 'Miguel Edward Rosal', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2024-11-22', 1, '5', '5', '5', '4', '5', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '4', '4', '4', '4', '4', '4', NULL, NULL),
(62, 4, 7, 'Donna Garcia', 'Miguel Edward Rosal', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2024-11-22', 1, '3', '4', '5', '4', '3', '4', '4', '3', '4', '4', '5', '4', '5', '4', '5', '4', '5', '4', '5', '4', '4', NULL, NULL),
(63, 5, 7, 'Eddie Jr. Bucad', 'Miguel Edward Rosal', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2024-11-22', 1, '2', '3', '4', '5', '4', '3', '4', '5', '4', '3', '5', '4', '5', '4', '5', '4', '5', '4', '5', '4', '3', NULL, NULL),
(64, 22, 7, 'Bryan Mondres', 'Miguel Edward Rosal', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2024-11-22', 1, '5', '4', '5', '4', '5', '4', '5', '4', '5', '4', '5', '4', '5', '4', '5', '5', '4', '5', '4', '5', '4', NULL, NULL),
(65, 23, 7, 'Michael Ramilo', 'Miguel Edward Rosal', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2024-11-22', 1, '5', '2', '3', '4', '5', '4', '5', '3', '4', '5', '4', '4', '5', '4', '5', '5', '5', '5', '5', '5', '4', NULL, NULL),
(66, 1, 8, 'Shiela Marie Garcia', 'Mary Jean Abejuela', 'FIRST', '2024-2025', 'Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '5', '4', '5', '5', '4', '4', '4', '5', '4', '4', '5', '5', '4', '5', '5', '5', '4', '3', '4', '5', '5', NULL, NULL),
(67, 24, 8, 'Hazel Joy Banayo', 'Mary Jean Abejuela', 'FIRST', '2024-2025', 'Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '5', '4', '3', '4', '5', '4', '5', '3', '4', '5', '5', '4', '3', '4', '5', '3', '4', '5', '4', '3', '4', NULL, NULL),
(68, 23, 8, 'Michael Ramilo', 'Mary Jean Abejuela', 'FIRST', '2024-2025', 'Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '5', '4', '3', '2', '1', '2', '3', '4', '4', '3', '3', '4', '5', '4', '3', '3', '2', '2', '3', '4', '3', NULL, NULL),
(69, 13, 8, 'Val Juniel Biscocho', 'Mary Jean Abejuela', 'FIRST', '2024-2025', 'Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '3', '4', '5', '4', '3', '4', '4', '5', '4', '3', '3', '4', '5', '4', '3', '3', '4', '5', '4', '3', '4', NULL, NULL),
(70, 12, 8, 'Nino Eusebio', 'Mary Jean Abejuela', 'FIRST', '2024-2025', 'Mauris ac consectetur ex, et convallis urna. Sed ullamcorper est sit amet eros sollicitudin, et vestibulum quam condimentum.', '2024-11-22', 1, '5', '4', '3', '4', '5', '4', '5', '4', '5', '4', '3', '4', '3', '4', '5', '4', '4', '4', '4', '4', '4', NULL, NULL),
(71, 25, 9, 'Noel Virrey', 'Melvin Babol', 'FIRST', '2024-2025', 'Aliquam egestas magna nisl, ut ultrices ex condimentum quis. Phasellus placerat volutpat blandit.', '2024-11-22', 1, '3', '4', '5', '4', '5', '5', '4', '5', '4', '4', '3', '4', '3', '3', '3', '5', '5', '4', '4', '4', '4', NULL, NULL),
(72, 2, 9, 'Johnrey Manzanal', 'Melvin Babol', 'FIRST', '2024-2025', 'Aliquam egestas magna nisl, ut ultrices ex condimentum quis. Phasellus placerat volutpat blandit.', '2024-11-22', 1, '3', '4', '5', '4', '3', '4', '4', '5', '4', '5', '3', '4', '5', '4', '3', '3', '4', '5', '4', '3', '4', NULL, NULL),
(73, 12, 9, 'Nino Eusebio', 'Melvin Babol', 'FIRST', '2024-2025', 'Vivamus blandit dictum enim, ut laoreet risus interdum non. Cras pulvinar ex vel massa gravida, at finibus felis ultricies.', '2024-11-22', 1, '2', '3', '4', '5', '4', '3', '4', '5', '4', '4', '3', '4', '5', '4', '3', '3', '4', '5', '4', '3', '3', NULL, NULL),
(74, 22, 9, 'Bryan Mondres', 'Melvin Babol', 'FIRST', '2024-2025', 'Vivamus blandit dictum enim, ut laoreet risus interdum non. Cras pulvinar ex vel massa gravida, at finibus felis ultricies.', '2024-11-22', 1, '5', '5', '4', '5', '4', '5', '4', '4', '3', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '5', '4', NULL, NULL),
(75, 20, 9, 'Ronald Tud', 'Melvin Babol', 'FIRST', '2024-2025', 'Vivamus blandit dictum enim, ut laoreet risus interdum non. Cras pulvinar ex vel massa gravida, at finibus felis ultricies.', '2024-11-22', 1, '3', '4', '5', '4', '3', '3', '4', '5', '4', '3', '5', '4', '3', '4', '5', '5', '4', '2', '4', '5', '4', NULL, NULL),
(76, 3, 10, 'Joseph Rizalde Guillo', 'Menard Canoy', 'FIRST', '2024-2025', 'Donec hendrerit tincidunt nisl a rutrum. Etiam laoreet id magna ac mollis.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '4', '4', '4', '4', '3', '3', '3', '3', '3', '3', '4', '5', '4', '3', '5', NULL, NULL),
(77, 1, 10, 'Shiela Marie Garcia', 'Menard Canoy', 'FIRST', '2024-2025', 'Donec hendrerit tincidunt nisl a rutrum. Etiam laoreet id magna ac mollis.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '4', '4', '4', '4', '3', '3', '3', '3', '3', '3', '4', '5', '4', '3', '5', NULL, NULL),
(78, 8, 10, 'Mary Jean Abejuela', 'Menard Canoy', 'FIRST', '2024-2025', 'Donec hendrerit tincidunt nisl a rutrum. Etiam laoreet id magna ac mollis.', '2024-11-22', 1, '4', '5', '4', '5', '4', '4', '4', '5', '4', '5', '4', '4', '5', '4', '4', '4', '5', '4', '4', '5', '5', NULL, NULL),
(79, 19, 10, 'Jasmin Pesigan', 'Menard Canoy', 'FIRST', '2024-2025', 'Donec hendrerit tincidunt nisl a rutrum. Etiam laoreet id magna ac mollis.', '2024-11-22', 1, '4', '4', '4', '5', '4', '5', '4', '5', '4', '5', '4', '4', '4', '4', '4', '4', '5', '5', '4', '5', '4', NULL, NULL),
(80, 13, 10, 'Val Juniel Biscocho', 'Menard Canoy', 'FIRST', '2024-2025', 'Donec hendrerit tincidunt nisl a rutrum. Etiam laoreet id magna ac mollis.', '2024-11-22', 1, '3', '4', '5', '4', '5', '5', '4', '5', '4', '4', '5', '5', '5', '5', '5', '4', '5', '4', '5', '5', '4', NULL, NULL),
(81, 7, 11, 'Miguel Edward Rosal', 'Cruzette Calzo', 'FIRST', '2024-2025', 'cruzette.calzo@g.batstate-u.edu.ph', '2024-11-22', 1, '5', '5', '5', '5', '5', '5', '4', '5', '4', '5', '4', '5', '5', '4', '5', '5', '4', '5', '4', '5', '5', NULL, NULL),
(82, 6, 11, 'Erwin De Castro', 'Cruzette Calzo', 'FIRST', '2024-2025', 'Pellentesque eget gravida justo. Sed sed quam consequat, convallis risus et, pharetra tortor.', '2024-11-22', 1, '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '4', '4', '4', '4', '5', '5', NULL, NULL),
(83, 23, 11, 'Michael Ramilo', 'Cruzette Calzo', 'FIRST', '2024-2025', 'Pellentesque eget gravida justo. Sed sed quam consequat, convallis risus et, pharetra tortor.', '2024-11-22', 1, '5', '4', '5', '4', '5', '4', '5', '4', '5', '5', '4', '4', '4', '4', '4', '5', '4', '5', '4', '5', '5', NULL, NULL),
(84, 13, 11, 'Val Juniel Biscocho', 'Cruzette Calzo', 'FIRST', '2024-2025', 'Pellentesque eget gravida justo. Sed sed quam consequat, convallis risus et, pharetra tortor.', '2024-11-22', 1, '5', '5', '4', '5', '4', '4', '4', '5', '4', '5', '5', '4', '5', '4', '5', '4', '5', '4', '3', '5', '5', NULL, NULL),
(85, 21, 11, 'Ariane Villanueva', 'Cruzette Calzo', 'FIRST', '2024-2025', 'Pellentesque eget gravida justo. Sed sed quam consequat, convallis risus et, pharetra tortor.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '4', '5', '5', '4', '5', '5', '5', '5', '5', '4', '5', '5', '4', '5', '5', NULL, NULL),
(86, 1, 12, 'Shiela Marie Garcia', 'Nino Eusebio', 'FIRST', '2024-2025', 'Mauris ac sem venenatis neque suscipit volutpat.', '2024-11-22', 1, '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '3', '3', '3', '3', '3', '4', '4', '4', '4', '4', '5', NULL, NULL),
(87, 24, 12, 'Hazel Joy Banayo', 'Nino Eusebio', 'FIRST', '2024-2025', 'Mauris ac sem venenatis neque suscipit volutpat.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '5', '4', '5', '4', '4', '5', '4', '5', '5', '5', '4', '5', '4', '5', '5', NULL, NULL),
(88, 7, 12, 'Miguel Edward Rosal', 'Nino Eusebio', 'FIRST', '2024-2025', 'Mauris ac sem venenatis neque suscipit volutpat.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '5', '5', '4', '5', '5', '5', '5', '5', '5', '5', '4', '5', '5', '5', '5', NULL, NULL),
(89, 20, 12, 'Ronald Tud', 'Nino Eusebio', 'FIRST', '2024-2025', 'Mauris ac sem venenatis neque suscipit volutpat.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '4', '4', '5', '4', '4', '5', NULL, NULL),
(90, 4, 12, 'Donna Garcia', 'Nino Eusebio', 'FIRST', '2024-2025', 'Mauris ac sem venenatis neque suscipit volutpat.', '2024-11-22', 1, '5', '5', '5', '5', '5', '5', '5', '5', '5', '5', '4', '4', '4', '4', '4', '3', '3', '3', '3', '3', '5', NULL, NULL),
(91, 7, 13, 'Miguel Edward Rosal', 'Val Juniel Biscocho', 'FIRST', '2024-2025', 'Cras ipsum sem, mollis non dui vel, efficitur scelerisque elit.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '5', '4', '5', '4', '4', '4', '5', '4', '5', '5', '5', '5', '5', '5', '5', NULL, NULL),
(92, 12, 13, 'Nino Eusebio', 'Val Juniel Biscocho', 'FIRST', '2024-2025', 'Cras ipsum sem, mollis non dui vel, efficitur scelerisque elit.', '2024-11-22', 1, '4', '5', '4', '5', '4', '3', '4', '5', '4', '3', '4', '5', '3', '4', '5', '5', '5', '5', '5', '5', '5', NULL, NULL),
(93, 21, 13, 'Ariane Villanueva', 'Val Juniel Biscocho', 'FIRST', '2024-2025', 'Cras ipsum sem, mollis non dui vel, efficitur scelerisque elit.', '2024-11-22', 1, '5', '5', '5', '4', '5', '3', '5', '3', '4', '5', '5', '4', '3', '4', '5', '5', '4', '4', '5', '5', '4', NULL, NULL),
(94, 2, 13, 'Johnrey Manzanal', 'Val Juniel Biscocho', 'FIRST', '2024-2025', 'Cras ipsum sem, mollis non dui vel, efficitur scelerisque elit.', '2024-11-22', 1, '5', '5', '5', '5', '5', '4', '5', '4', '5', '5', '5', '4', '5', '4', '5', '5', '5', '5', '5', '3', '5', NULL, NULL),
(95, 25, 13, 'Noel Virrey', 'Val Juniel Biscocho', 'FIRST', '2024-2025', 'Cras ipsum sem, mollis non dui vel, efficitur scelerisque elit.', '2024-11-22', 1, '5', '4', '3', '4', '5', '5', '4', '3', '4', '5', '5', '4', '4', '4', '5', '5', '4', '4', '4', '4', '4', NULL, NULL),
(96, 11, 19, 'Cruzette Calzo', 'Jasmin Pesigan', 'FIRST', '2024-2025', 'Nam dui dolor, vulputate sed posuere eget, ultricies eget erat. Donec vel maximus nisi, at laoreet tortor. Fusce mi dui, sagittis et mi consequat, fermentum tristique nibh.', '2024-11-22', 1, '1', '2', '3', '4', '3', '2', '3', '2', '3', '4', '2', '3', '3', '4', '5', '3', '4', '3', '4', '5', '4', NULL, NULL),
(97, 5, 19, 'Eddie Jr. Bucad', 'Jasmin Pesigan', 'FIRST', '2024-2025', 'Nulla molestie est mauris, in pellentesque nulla vestibulum quis. Mauris tortor leo, mollis ac posuere vitae, facilisis sit amet ex. Morbi fermentum porta pellentesque.', '2024-11-22', 1, '1', '2', '2', '3', '4', '2', '3', '2', '3', '4', '2', '3', '3', '4', '5', '3', '4', '3', '4', '5', '3', NULL, NULL),
(98, 4, 19, 'Donna Garcia', 'Jasmin Pesigan', 'FIRST', '2024-2025', 'Sed gravida sapien sed dui eleifend maximus. Curabitur quis orci pellentesque, ultricies purus sed, sodales purus.', '2024-11-22', 1, '2', '3', '2', '3', '4', '3', '4', '3', '4', '5', '2', '3', '3', '4', '5', '4', '3', '4', '3', '2', '5', NULL, NULL),
(99, 20, 19, 'Ronald Tud', 'Jasmin Pesigan', 'FIRST', '2024-2025', 'In vitae luctus magna, et consectetur nibh. Donec porta tellus eu molestie pulvinar. Duis non diam lectus. Nulla facilisi.', '2024-11-22', 1, '1', '2', '2', '3', '3', '4', '4', '4', '4', '5', '5', '5', '5', '5', '5', '5', '4', '3', '2', '1', '3', NULL, NULL),
(100, 8, 19, 'Mary Jean Abejuela', 'Jasmin Pesigan', 'FIRST', '2024-2025', 'Vivamus sodales, magna vitae auctor blandit, tortor odio imperdiet felis, nec auctor risus diam a nisl. In tincidunt urna sit amet malesuada aliquet.', '2024-11-22', 1, '2', '2', '3', '2', '3', '2', '3', '2', '3', '4', '2', '3', '2', '3', '4', '3', '3', '4', '4', '5', '4', NULL, NULL),
(101, 22, 20, 'Bryan Mondres', 'Ronald Tud', 'FIRST', '2024-2025', 'Vivamus at massa gravida, semper est quis, semper leo.', '2024-11-22', 1, '2', '3', '3', '4', '3', '2', '3', '3', '3', '4', '5', '4', '3', '4', '3', '3', '3', '4', '4', '5', '4', NULL, NULL),
(102, 5, 20, 'Eddie Jr. Bucad', 'Ronald Tud', 'FIRST', '2024-2025', 'Ut interdum consequat pulvinar. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Integer ut pulvinar arcu, eu efficitur neque.', '2024-11-22', 1, '1', '2', '3', '4', '5', '5', '4', '3', '2', '1', '3', '4', '3', '4', '5', '3', '4', '3', '4', '4', '4', NULL, NULL),
(103, 23, 20, 'Michael Ramilo', 'Ronald Tud', 'FIRST', '2024-2025', 'Aenean at orci eget mi commodo facilisis. Proin mollis in sapien a elementum.', '2024-11-22', 1, '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '5', '4', '3', '2', '3', '2', '3', '2', '3', '4', '4', NULL, NULL),
(104, 13, 20, 'Val Juniel Biscocho', 'Ronald Tud', 'FIRST', '2024-2025', 'Vestibulum nisl urna, mollis a dolor vitae, rutrum fermentum elit.', '2024-11-22', 1, '5', '4', '3', '2', '3', '5', '4', '3', '2', '3', '5', '4', '2', '3', '4', '2', '3', '4', '3', '4', '4', NULL, NULL),
(105, 11, 20, 'Cruzette Calzo', 'Ronald Tud', 'FIRST', '2024-2025', 'Nunc egestas augue in mi iaculis vehicula. Integer libero turpis, dignissim eget vestibulum et, convallis ut diam.', '2024-11-22', 1, '3', '3', '3', '4', '3', '5', '3', '3', '2', '3', '5', '4', '3', '4', '5', '5', '4', '4', '3', '5', '4', NULL, NULL),
(106, 5, 21, 'Eddie Jr. Bucad', 'Ariane Villanueva', 'FIRST', '2024-2025', 'Aenean velit turpis, finibus ac vulputate at, rhoncus in nisi.', '2024-11-22', 1, '2', '3', '4', '3', '4', '5', '4', '3', '2', '2', '2', '3', '3', '4', '5', '5', '4', '4', '3', '4', '5', NULL, NULL),
(107, 6, 21, 'Erwin De Castro', 'Ariane Villanueva', 'FIRST', '2024-2025', 'Quisque eu odio facilisis, vulputate orci quis, ultricies ligula.', '2024-11-22', 1, '5', '4', '3', '2', '2', '2', '3', '3', '4', '5', '3', '3', '3', '4', '5', '5', '4', '3', '4', '5', '2', NULL, NULL),
(108, 8, 21, 'Mary Jean Abejuela', 'Ariane Villanueva', 'FIRST', '2024-2025', 'Maecenas vitae faucibus ligula, non gravida urna. Vestibulum finibus quam nec metus fringilla placerat.', '2024-11-22', 1, '5', '4', '4', '5', '4', '5', '4', '3', '2', '2', '3', '4', '3', '4', '5', '3', '2', '3', '4', '5', '3', NULL, NULL),
(109, 9, 21, 'Melvin Babol', 'Ariane Villanueva', 'FIRST', '2024-2025', 'Curabitur sodales aliquet dolor quis porttitor.', '2024-11-22', 1, '5', '4', '1', '2', '2', '5', '4', '3', '2', '3', '5', '4', '5', '3', '4', '3', '3', '4', '5', '4', '5', NULL, NULL),
(110, 19, 21, 'Jasmin Pesigan', 'Ariane Villanueva', 'FIRST', '2024-2025', 'Nam a congue arcu. Quisque vel eleifend lectus. Aliquam scelerisque est sed pellentesque pretium.', '2024-11-22', 1, '2', '3', '3', '4', '4', '5', '4', '5', '4', '5', '5', '4', '4', '3', '5', '5', '4', '5', '3', '4', '3', NULL, NULL),
(111, 3, 22, 'Joseph Rizalde Guillo', 'Bryan Mondres', 'FIRST', '2024-2025', 'Nunc vestibulum luctus venenatis.', '2024-11-22', 1, '5', '4', '3', '4', '3', '5', '4', '2', '3', '4', '5', '4', '2', '2', '3', '5', '4', '5', '4', '2', '2', NULL, NULL),
(112, 24, 22, 'Hazel Joy Banayo', 'Bryan Mondres', 'FIRST', '2024-2025', 'Morbi bibendum orci lacinia lacus pharetra, volutpat mollis eros condimentum.', '2024-11-22', 1, '5', '4', '3', '2', '1', '5', '4', '5', '2', '5', '5', '4', '4', '3', '2', '5', '3', '5', '4', '5', '1', NULL, NULL),
(113, 8, 22, 'Mary Jean Abejuela', 'Bryan Mondres', 'FIRST', '2024-2025', 'Duis in mollis nibh. Aliquam placerat euismod accumsan.', '2024-11-22', 1, '5', '4', '3', '2', '3', '5', '4', '3', '4', '2', '5', '5', '5', '4', '5', '5', '4', '3', '2', '3', '5', NULL, NULL),
(114, 23, 22, 'Michael Ramilo', 'Bryan Mondres', 'FIRST', '2024-2025', 'Maecenas lectus tellus, dictum a tincidunt nec, maximus ut velit.', '2024-11-22', 1, '5', '4', '3', '2', '2', '4', '5', '4', '3', '3', '5', '4', '5', '4', '2', '5', '5', '4', '2', '3', '2', NULL, NULL),
(115, 10, 22, 'Menard Canoy', 'Bryan Mondres', 'FIRST', '2024-2025', 'Morbi mollis lectus sit amet eros volutpat tristique.', '2024-11-22', 1, '5', '4', '5', '2', '3', '2', '3', '3', '4', '5', '5', '4', '2', '3', '5', '5', '4', '5', '4', '4', '4', NULL, NULL),
(116, 8, 23, 'Mary Jean Abejuela', 'Michael Ramilo', 'FIRST', '2024-2025', 'Integer dignissim, lectus vel tincidunt tincidunt, sem lectus cursus nulla, eu efficitur est odio vitae nunc.', '2024-11-22', 1, '5', '4', '3', '4', '3', '5', '4', '3', '2', '3', '5', '4', '5', '4', '2', '3', '4', '5', '4', '5', '2', NULL, NULL),
(117, 2, 23, 'Johnrey Manzanal', 'Michael Ramilo', 'FIRST', '2024-2025', 'Quisque id dapibus quam, vel pharetra purus. Fusce lacinia ornare porttitor.', '2024-11-22', 1, '3', '3', '4', '5', '5', '5', '4', '2', '3', '4', '3', '4', '3', '4', '5', '2', '3', '2', '3', '4', '5', NULL, NULL),
(118, 10, 23, 'Menard Canoy', 'Michael Ramilo', 'FIRST', '2024-2025', 'Phasellus est massa, luctus sit amet venenatis condimentum, maximus sit amet ligula.', '2024-11-22', 1, '5', '4', '4', '3', '3', '5', '4', '3', '2', '3', '2', '3', '2', '3', '4', '3', '4', '4', '5', '5', '2', NULL, NULL),
(119, 3, 23, 'Joseph Rizalde Guillo', 'Michael Ramilo', 'FIRST', '2024-2025', 'In mattis fringilla eros, vitae euismod diam tristique sed.', '2024-11-22', 1, '3', '4', '3', '4', '3', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '5', '4', '5', '2', '3', '4', NULL, NULL),
(120, 6, 23, 'Erwin De Castro', 'Michael Ramilo', 'FIRST', '2024-2025', 'Etiam mauris dui, tempor vel dictum at, gravida id nisl.', '2024-11-22', 1, '3', '4', '3', '4', '5', '3', '4', '3', '4', '3', '3', '4', '2', '3', '5', '3', '4', '5', '4', '2', '4', NULL, NULL),
(121, 9, 24, 'Melvin Babol', 'Hazel Joy Banayo', 'FIRST', '2024-2025', 'Nunc erat sem, interdum vel nisl at, ultrices congue nibh.', '2024-11-22', 1, '2', '3', '2', '3', '4', '5', '4', '3', '2', '3', '3', '4', '3', '4', '5', '3', '4', '5', '4', '5', '5', NULL, NULL),
(122, 12, 24, 'Nino Eusebio', 'Hazel Joy Banayo', 'FIRST', '2024-2025', 'Quisque vitae justo ullamcorper, malesuada justo pharetra, tincidunt odio.', '2024-11-22', 1, '4', '5', '4', '5', '4', '5', '4', '3', '2', '3', '2', '3', '4', '5', '5', '5', '5', '5', '4', '5', '5', NULL, NULL),
(123, 19, 24, 'Jasmin Pesigan', 'Hazel Joy Banayo', 'FIRST', '2024-2025', 'Maecenas et eros aliquet, egestas dui eu, cursus lacus.', '2024-11-22', 1, '1', '2', '3', '3', '4', '5', '4', '3', '2', '3', '2', '3', '4', '4', '5', '5', '4', '3', '3', '4', '4', NULL, NULL),
(124, 3, 24, 'Joseph Rizalde Guillo', 'Hazel Joy Banayo', 'FIRST', '2024-2025', 'Integer gravida tellus at libero porta tempor.', '2024-11-22', 1, '5', '4', '3', '4', '3', '5', '4', '5', '2', '3', '5', '3', '2', '3', '5', '2', '3', '4', '3', '5', '5', NULL, NULL),
(125, 11, 24, 'Cruzette Calzo', 'Hazel Joy Banayo', 'FIRST', '2024-2025', 'Maecenas scelerisque dolor ut tincidunt bibendum.', '2024-11-22', 1, '5', '4', '5', '3', '4', '5', '4', '2', '3', '4', '5', '4', '2', '3', '4', '3', '4', '3', '4', '5', '5', NULL, NULL),
(126, 10, 25, 'Menard Canoy', 'Noel Virrey', 'FIRST', '2024-2025', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '2024-11-22', 1, '1', '2', '3', '4', '5', '5', '4', '2', '3', '4', '3', '4', '3', '4', '5', '3', '4', '3', '5', '5', '4', NULL, NULL),
(127, 1, 25, 'Shiela Marie Garcia', 'Noel Virrey', 'FIRST', '2024-2025', 'Cras condimentum dolor eget varius blandit. Praesent finibus arcu eu purus consectetur sollicitudin.', '2024-11-22', 1, '5', '4', '5', '4', '5', '5', '4', '5', '4', '5', '5', '4', '5', '4', '5', '5', '4', '3', '4', '5', '4', NULL, NULL),
(128, 3, 25, 'Joseph Rizalde Guillo', 'Noel Virrey', 'FIRST', '2024-2025', '. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae', '2024-11-22', 1, '1', '2', '3', '3', '4', '3', '4', '3', '4', '5', '5', '4', '2', '3', '4', '5', '4', '5', '3', '4', '5', NULL, NULL),
(129, 22, 25, 'Bryan Mondres', 'Noel Virrey', 'FIRST', '2024-2025', 'Suspendisse rutrum, eros eu semper tincidunt, augue felis porttitor metus, quis tristique ante est vitae massa.', '2024-11-22', 1, '4', '3', '4', '5', '3', '5', '4', '4', '5', '5', '5', '4', '3', '4', '5', '4', '4', '5', '4', '5', '5', NULL, NULL),
(130, 24, 25, 'Hazel Joy Banayo', 'Noel Virrey', 'FIRST', '2024-2025', 'Mauris dignissim ultrices euismod. In hac habitasse platea dictumst.', '2024-11-22', 1, '5', '4', '3', '2', '3', '2', '3', '3', '4', '5', '5', '4', '3', '4', '5', '4', '4', '5', '4', '5', '2', NULL, NULL),
(131, 8, 1, 'Mary Jean Abejuela', 'Shiela Marie Garcia', 'SECOND', '2024-2025', 'Test', '2024-11-23', 1, '3', '4', '4', '5', '4', '2', '3', '3', '4', '5', '5', '4', '3', '4', '5', '3', '4', '4', '5', '3', '5', NULL, NULL),
(132, 19, 1, 'Jasmin Pesigan', 'Shiela Marie Garcia', 'SECOND', '2024-2025', 'test po', '2024-11-23', 1, '1', '2', '3', '4', '5', '5', '4', '3', '4', '5', '5', '4', '3', '2', '3', '3', '4', '5', '4', '5', '4', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `preferredschedule`
--

CREATE TABLE `preferredschedule` (
  `id` int(11) NOT NULL,
  `faculty_Id` varchar(255) NOT NULL,
  `courseClassroom` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `dayOfWeek` varchar(255) NOT NULL,
  `startTimePreferred` varchar(255) NOT NULL,
  `endTimePreferred` varchar(255) NOT NULL,
  `dayOfWeekTwo` varchar(255) NOT NULL,
  `startTimeSecondary` varchar(255) NOT NULL,
  `endTimeSecondary` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prereq_subject`
--

CREATE TABLE `prereq_subject` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `prereq_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prereq_subject`
--

INSERT INTO `prereq_subject` (`id`, `subject_id`, `prereq_id`, `year_id`) VALUES
(1, 41, 4, 1),
(2, 42, 4, 1),
(3, 44, 53, 1),
(4, 47, 55, 1),
(5, 45, 54, 1),
(6, 33, 41, 2),
(8, 42, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `randomfaculty`
--

CREATE TABLE `randomfaculty` (
  `id` int(255) NOT NULL,
  `faculty_Id` int(255) NOT NULL,
  `random_Id` int(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `doneStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `randomfaculty`
--

INSERT INTO `randomfaculty` (`id`, `faculty_Id`, `random_Id`, `semester`, `academic_year`, `doneStatus`) VALUES
(832, 2, 7, 'SECOND', '2024-2025', 0),
(833, 2, 19, 'SECOND', '2024-2025', 0),
(834, 2, 9, 'SECOND', '2024-2025', 0),
(835, 2, 13, 'SECOND', '2024-2025', 0),
(836, 2, 21, 'SECOND', '2024-2025', 0),
(837, 3, 11, 'SECOND', '2024-2025', 0),
(838, 3, 2, 'SECOND', '2024-2025', 0),
(839, 3, 22, 'SECOND', '2024-2025', 0),
(840, 3, 24, 'SECOND', '2024-2025', 0),
(841, 3, 21, 'SECOND', '2024-2025', 0),
(842, 22, 5, 'SECOND', '2024-2025', 0),
(843, 22, 3, 'SECOND', '2024-2025', 0),
(844, 22, 24, 'SECOND', '2024-2025', 0),
(845, 22, 7, 'SECOND', '2024-2025', 0),
(846, 22, 11, 'SECOND', '2024-2025', 0),
(847, 10, 7, 'SECOND', '2024-2025', 0),
(848, 10, 23, 'SECOND', '2024-2025', 0),
(849, 10, 19, 'SECOND', '2024-2025', 0),
(850, 10, 2, 'SECOND', '2024-2025', 0),
(851, 10, 13, 'SECOND', '2024-2025', 0),
(852, 4, 21, 'SECOND', '2024-2025', 0),
(853, 4, 22, 'SECOND', '2024-2025', 0),
(854, 4, 5, 'SECOND', '2024-2025', 0),
(855, 4, 10, 'SECOND', '2024-2025', 0),
(856, 4, 20, 'SECOND', '2024-2025', 0),
(857, 25, 22, 'SECOND', '2024-2025', 0),
(858, 25, 12, 'SECOND', '2024-2025', 0),
(859, 25, 2, 'SECOND', '2024-2025', 0),
(860, 25, 8, 'SECOND', '2024-2025', 0),
(861, 25, 24, 'SECOND', '2024-2025', 0),
(862, 8, 25, 'SECOND', '2024-2025', 0),
(863, 8, 12, 'SECOND', '2024-2025', 0),
(864, 8, 5, 'SECOND', '2024-2025', 0),
(865, 8, 2, 'SECOND', '2024-2025', 0),
(866, 8, 4, 'SECOND', '2024-2025', 0),
(867, 9, 5, 'SECOND', '2024-2025', 0),
(868, 9, 21, 'SECOND', '2024-2025', 0),
(869, 9, 6, 'SECOND', '2024-2025', 0),
(870, 9, 13, 'SECOND', '2024-2025', 0),
(871, 9, 12, 'SECOND', '2024-2025', 0),
(872, 7, 12, 'SECOND', '2024-2025', 0),
(873, 7, 21, 'SECOND', '2024-2025', 0),
(874, 7, 13, 'SECOND', '2024-2025', 0),
(875, 7, 11, 'SECOND', '2024-2025', 0),
(876, 7, 23, 'SECOND', '2024-2025', 0),
(877, 5, 6, 'SECOND', '2024-2025', 0),
(878, 5, 10, 'SECOND', '2024-2025', 0),
(879, 5, 11, 'SECOND', '2024-2025', 0),
(880, 5, 25, 'SECOND', '2024-2025', 0),
(881, 5, 12, 'SECOND', '2024-2025', 0),
(882, 20, 8, 'SECOND', '2024-2025', 0),
(883, 20, 7, 'SECOND', '2024-2025', 0),
(884, 20, 9, 'SECOND', '2024-2025', 0),
(885, 20, 5, 'SECOND', '2024-2025', 0),
(886, 20, 23, 'SECOND', '2024-2025', 0),
(887, 19, 2, 'SECOND', '2024-2025', 0),
(888, 19, 6, 'SECOND', '2024-2025', 0),
(889, 19, 11, 'SECOND', '2024-2025', 0),
(890, 19, 7, 'SECOND', '2024-2025', 0),
(891, 19, 1, 'SECOND', '2024-2025', 0),
(892, 13, 19, 'SECOND', '2024-2025', 0),
(893, 13, 10, 'SECOND', '2024-2025', 0),
(894, 13, 24, 'SECOND', '2024-2025', 0),
(895, 13, 9, 'SECOND', '2024-2025', 0),
(896, 13, 1, 'SECOND', '2024-2025', 0),
(897, 6, 23, 'SECOND', '2024-2025', 0),
(898, 6, 1, 'SECOND', '2024-2025', 0),
(899, 6, 10, 'SECOND', '2024-2025', 0),
(900, 6, 8, 'SECOND', '2024-2025', 0),
(901, 6, 3, 'SECOND', '2024-2025', 0),
(902, 1, 8, 'SECOND', '2024-2025', 1),
(903, 1, 19, 'SECOND', '2024-2025', 1),
(904, 1, 10, 'SECOND', '2024-2025', 0),
(905, 1, 24, 'SECOND', '2024-2025', 0),
(906, 1, 22, 'SECOND', '2024-2025', 0),
(907, 21, 3, 'SECOND', '2024-2025', 0),
(908, 21, 22, 'SECOND', '2024-2025', 0),
(909, 21, 1, 'SECOND', '2024-2025', 0),
(910, 21, 20, 'SECOND', '2024-2025', 0),
(911, 21, 13, 'SECOND', '2024-2025', 0),
(912, 11, 9, 'SECOND', '2024-2025', 0),
(913, 11, 3, 'SECOND', '2024-2025', 0),
(914, 11, 8, 'SECOND', '2024-2025', 0),
(915, 11, 23, 'SECOND', '2024-2025', 0),
(916, 11, 20, 'SECOND', '2024-2025', 0),
(917, 23, 25, 'SECOND', '2024-2025', 0),
(918, 23, 3, 'SECOND', '2024-2025', 0),
(919, 23, 9, 'SECOND', '2024-2025', 0),
(920, 23, 1, 'SECOND', '2024-2025', 0),
(921, 23, 6, 'SECOND', '2024-2025', 0),
(922, 12, 25, 'SECOND', '2024-2025', 0),
(923, 12, 20, 'SECOND', '2024-2025', 0),
(924, 12, 6, 'SECOND', '2024-2025', 0),
(925, 12, 19, 'SECOND', '2024-2025', 0),
(926, 12, 4, 'SECOND', '2024-2025', 0),
(927, 24, 4, 'SECOND', '2024-2025', 0),
(928, 24, 25, 'SECOND', '2024-2025', 0),
(929, 24, 20, 'SECOND', '2024-2025', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `room` varchar(255) NOT NULL,
  `selected_date` date NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `slot` int(11) NOT NULL,
  `evaluation_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `course`, `instructor`, `room`, `selected_date`, `start_time`, `end_time`, `slot`, `evaluation_status`) VALUES
(11, 'paks', 'admin', 'paks', '2024-09-29', 7, 10, 1, 0),
(12, 'sss', 'admin', 'sss', '2024-09-29', 7, 10, 1, 0),
(13, 'a', 'admin', 'a', '2024-09-29', 7, 8, 1, 0),
(14, 'a', 'admin', 'a', '2024-09-29', 7, 10, 1, 0),
(15, 'inangyan', 'admin', 'inangyan', '2024-09-29', 7, 10, 1, 0),
(11, 'paks', 'admin', 'paks', '2024-09-29', 7, 10, 1, 0),
(12, 'sss', 'admin', 'sss', '2024-09-29', 7, 10, 1, 0),
(13, 'a', 'admin', 'a', '2024-09-29', 7, 8, 1, 0),
(14, 'a', 'admin', 'a', '2024-09-29', 7, 10, 1, 0),
(15, 'inangyan', 'admin', 'inangyan', '2024-09-29', 7, 10, 1, 0),
(11, 'paks', 'admin', 'paks', '2024-09-29', 7, 10, 1, 0),
(12, 'sss', 'admin', 'sss', '2024-09-29', 7, 10, 1, 0),
(13, 'a', 'admin', 'a', '2024-09-29', 7, 8, 1, 0),
(14, 'a', 'admin', 'a', '2024-09-29', 7, 10, 1, 0),
(15, 'inangyan', 'admin', 'inangyan', '2024-09-29', 7, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` int(11) NOT NULL,
  `section` varchar(30) NOT NULL,
  `year_id` int(11) NOT NULL,
  `sem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `section`, `year_id`, `sem_id`) VALUES
(1, 'IT-1101', 1, 1),
(2, 'IT-1102', 1, 1),
(3, 'IT-1103', 1, 1),
(4, 'IT-1201', 1, 2),
(5, 'IT-1202', 1, 2),
(6, 'IT-1203', 1, 2),
(7, 'IT-2101', 2, 1),
(8, 'IT-2102', 2, 1),
(9, 'IT-2103', 2, 1),
(10, 'IT-2201', 2, 2),
(11, 'IT-2202', 2, 2),
(12, 'IT-2203', 2, 2),
(13, 'ITSM-3201', 3, 2),
(14, 'ITBA-3201', 3, 2),
(15, 'ITSM-4101', 4, 1),
(16, 'ITBA-4101', 4, 1),
(17, 'IT-1104', 1, 1),
(18, 'IT-1105', 1, 1),
(19, 'IT-1106', 1, 1),
(20, 'IT-1204', 1, 2),
(21, 'IT-1205', 1, 2),
(22, 'IT-1206', 1, 2),
(23, 'IT-2104', 2, 1),
(24, 'IT-2204', 2, 2),
(25, 'ITNT-3101', 3, 1),
(26, 'ITNT-3201', 3, 2),
(27, 'ITSM-3101', 3, 1),
(28, 'ITSM-3102', 3, 1),
(29, 'ITSM-3202', 3, 2),
(30, 'ITBA-3101', 3, 1),
(31, 'ITBA-3102', 3, 1),
(32, 'ITBA-3103', 3, 1),
(33, 'ITBA-3202', 3, 2),
(34, 'ITBA-3203', 3, 2),
(35, 'ITNT-4101', 4, 1),
(36, 'ITSM-4102', 4, 1),
(37, 'ITBA-4102', 4, 1),
(38, 'ITBA-4103', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `sem_id` int(11) NOT NULL,
  `semester` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`sem_id`, `semester`) VALUES
(1, 'FIRST'),
(2, 'SECOND');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'Regular'),
(2, 'Irregular');

-- --------------------------------------------------------

--
-- Table structure for table `studentlogin`
--

CREATE TABLE `studentlogin` (
  `id` int(11) NOT NULL,
  `srcode` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentlogin`
--

INSERT INTO `studentlogin` (`id`, `srcode`, `password`, `usertype`, `status`) VALUES
(25, '23-46378', 'JOHNSON', 'student', 1),
(26, '23-46379', 'WILLIAMS', 'student', 1),
(27, '23-46380', 'DAVIS', 'student', 1),
(28, '23-46382', 'RODRIGUEZ', 'student', 1),
(29, '23-46383', 'LEE', 'student', 1),
(30, '23-46384', 'WILSON', 'student', 1),
(31, '23-46385', 'CLARK', 'student', 1),
(32, '23-46386', 'HARRIS', 'student', 1),
(33, '23-46387', 'LEWIS', 'student', 1),
(34, '23-46388', 'HALL', 'student', 1),
(35, '23-46389', 'MARTINEZ', 'student', 1),
(36, '23-46390', 'YOUNG', 'student', 1),
(37, '23-46391', 'WALKER', 'student', 1),
(38, '23-46392', 'KING', 'student', 1),
(39, '23-46393', 'SCOTT', 'student', 1),
(40, '23-46394', 'ADAMS', 'student', 1),
(41, '23-46395', 'NELSON', 'student', 1),
(42, '23-46396', 'CARTER', 'student', 1),
(43, '23-46397', 'WRIGHT', 'student', 1),
(44, '23-46398', 'REED', 'student', 1),
(45, '23-46399', 'RIVERA', 'student', 1),
(46, '23-46400', 'MITCHELL', 'student', 1),
(47, '23-46401', 'PEREZ', 'student', 1),
(48, '23-46402', 'SANCHEZ', 'student', 1),
(49, '23-46403', 'HILL', 'student', 1),
(50, '23-46404', 'LONG', 'student', 1),
(51, '23-46405', 'BAKER', 'student', 1),
(52, '23-46406', 'COOPER', 'student', 1),
(53, '23-46407', 'MORGAN', 'student', 1),
(54, '23-46408', 'BELL', 'student', 1),
(55, '23-46409', 'MURPHY', 'student', 1),
(56, '23-46410', 'LEE', 'student', 1),
(57, '23-46411', 'GREEN', 'student', 1),
(58, '23-46412', 'SCOTT', 'student', 1),
(59, '23-46413', 'TURNER', 'student', 1),
(60, '23-46414', 'RIVERA', 'student', 1),
(61, '19-63308', 'MIKE', 'student', 1),
(62, '22-46378', 'JOHNSON', 'student', 1),
(63, '22-46379', 'GARCIA', 'student', 1),
(64, '22-46380', 'WILSON', 'student', 1),
(65, '22-46381', 'WHITE', 'student', 1),
(66, '22-46382', 'MARTINEZ', 'student', 1),
(67, '22-46383', 'ROBINSON', 'student', 1),
(68, '22-46384', 'THOMPSON', 'student', 1),
(69, '22-46385', 'JOHNSON', 'student', 1),
(70, '22-46386', 'LEE', 'student', 1),
(71, '22-46387', 'HARRIS', 'student', 1),
(72, '22-46388', 'FOSTER', 'student', 1),
(73, '22-46389', 'YOUNG', 'student', 1),
(74, '22-46390', 'WRIGHT', 'student', 1),
(75, '22-46391', 'HALL', 'student', 1),
(76, '22-46392', 'LEWIS', 'student', 1),
(77, '22-46393', 'SCOTT', 'student', 1),
(78, '22-46394', 'CARTER', 'student', 1),
(79, '22-46395', 'HALL', 'student', 1),
(80, '22-46396', 'GREEN', 'student', 1),
(81, '22-46397', 'BAKER', 'student', 1),
(82, '24-46378', 'SMITH', 'student', 1),
(83, '22-01234', 'TEST', 'student', 1),
(84, '22-00941', 'RETS', 'student', 2);

-- --------------------------------------------------------

--
-- Table structure for table `studentscategories`
--

CREATE TABLE `studentscategories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `linkOne` text NOT NULL,
  `linkTwo` text NOT NULL,
  `linkThree` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentscategories`
--

INSERT INTO `studentscategories` (`id`, `categories`, `linkOne`, `linkTwo`, `linkThree`) VALUES
(3, 'TEACHING EFFECTIVENESS', '', '', ''),
(4, 'CLASSROOM MANAGEMENT', 'https://youtube.com/playlist?list=PLg2YHlc8f1l-0zPMLsAVXJ4NHZw0VLLH6&si=lfKlW0I0KbcG1fll', 'https://youtube.com/playlist?list=PLiCu2U0GX77WWmQzBeeDKMMVCHGFbmhvb&si=uly2Z1nOGNnAaTuh', ''),
(5, 'STUDENT ENGAGEMENT', 'https://youtube.com/playlist?list=PLmKUwJ0KJQnVSOFvq_l6evaWBa3yyuFhD&si=BMJDBYHIoC-2xzaB', 'https://youtube.com/playlist?list=PLF19180008E030FB4&si=0WPxryMGEh0KoqZu', ''),
(6, 'COMMUNICATION', 'https://youtube.com/playlist?list=PLOaeOd121eBEEWP14TYgSnFsvaTIjPD22&si=Y9uarmE3nrsu8nQt', 'https://youtube.com/playlist?list=PLm_MSClsnwm-AIEbpyIxoTT8t7UzkHSYC&si=miKT_kHQSLSVHLOE', ''),
(7, 'EMOTIONAL COMPETENCE', 'https://youtube.com/playlist?list=PLIzpm3r_JgAIZfvbaDz5IXhHhyLW4IjGT&si=qyRM1nJo9f5KxuN7', 'https://youtube.com/playlist?list=PLb-IVyP8mpP6zBE9YkBtvRcoCuVlu8mUO&si=jrnd0_EmNXDLoqsD', '');

-- --------------------------------------------------------

--
-- Table structure for table `studentscriteria`
--

CREATE TABLE `studentscriteria` (
  `id` int(11) NOT NULL,
  `studentsCategories` text NOT NULL,
  `studentsCriteria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentscriteria`
--

INSERT INTO `studentscriteria` (`id`, `studentsCategories`, `studentsCriteria`) VALUES
(3, 'TEACHING EFFECTIVENESS', 'Demonstrates a strong knowledge of the subject and answers questions accurately and confidently'),
(4, 'TEACHING EFFECTIVENESS', 'Stays updated with the latest developments and trends in the subject matter'),
(5, 'TEACHING EFFECTIVENESS', 'Explains topics clearly and makes them easy to understand, so I can follow the lessons without confusion.'),
(6, 'TEACHING EFFECTIVENESS', 'Provides relevant examples that help me grasp difficult concepts more easily.'),
(7, 'TEACHING EFFECTIVENESS', 'Connects what we are learning to real-life situations, showing how it applies outside of class.'),
(8, 'TEACHING EFFECTIVENESS', 'Adapts their teaching methods to different learning styles, helping me understand the material better.'),
(9, 'CLASSROOM MANAGEMENT', 'Starts and ends classes on time, respecting my schedule and keeping things organized.'),
(11, 'CLASSROOM MANAGEMENT', 'Keeps the class focused on the topic and minimizes distractions.'),
(12, 'CLASSROOM MANAGEMENT', 'Handles any disruptions in the classroom quickly and effectively, maintaining a positive learning environment.'),
(13, 'CLASSROOM MANAGEMENT', 'Makes classroom environment positive and encouraging, making it easier for me to participate and learn.'),
(15, 'CLASSROOM MANAGEMENT', 'Manages classroom time well, balancing different activities and covering all necessary topics.'),
(17, 'STUDENT ENGAGEMENT', 'Encourages me to participate in class discussions and activities.'),
(18, 'STUDENT ENGAGEMENT', 'Learning activities are enjoyable and help keep me interested in the subject matter.'),
(19, 'STUDENT ENGAGEMENT', 'Activities used in class help me understand and remember the material better.'),
(20, 'STUDENT ENGAGEMENT', 'The instructor shows genuine concern for my progress and provides support to help me succeed.'),
(21, 'STUDENT ENGAGEMENT', 'The instructor motivates me to do my best through encouragement and positive reinforcement.'),
(22, 'COMMUNICATION', 'Clearly explains what is expected in the course, including goals and grading criteria.'),
(23, 'COMMUNICATION', 'Answers my questions promptly and provides clear explanations.'),
(24, 'COMMUNICATION', 'Lessons are explained in a straightforward way that is easy for me to understand.'),
(25, 'COMMUNICATION', 'There is effective communication between the instructor and me, allowing for open discussion and feedback.'),
(26, 'COMMUNICATION', 'Feedback on my assignments and exams is given in a helpful manner, guiding me on how to improve.'),
(27, 'EMOTIONAL COMPETENCE', 'The instructor handles their emotions effectively, creating a calm and stable classroom environment.'),
(28, 'EMOTIONAL COMPETENCE', 'The instructor is approachable and respectful, making me feel valued and heard.'),
(29, 'EMOTIONAL COMPETENCE', 'The classroom atmosphere is warm and supportive, contributing to a positive learning experience.');

-- --------------------------------------------------------

--
-- Table structure for table `studentsform`
--

CREATE TABLE `studentsform` (
  `id` int(11) NOT NULL,
  `srcode` varchar(255) NOT NULL,
  `studentSection` varchar(255) NOT NULL,
  `toFacultyID` int(11) NOT NULL,
  `fromStudentID` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `academic_year` varchar(50) NOT NULL,
  `toFaculty` varchar(255) NOT NULL,
  `fromStudents` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `TEACHINGEFFECTIVENESS3` varchar(255) DEFAULT NULL,
  `TEACHINGEFFECTIVENESS4` varchar(255) DEFAULT NULL,
  `TEACHINGEFFECTIVENESS5` varchar(255) DEFAULT NULL,
  `TEACHINGEFFECTIVENESS6` varchar(255) DEFAULT NULL,
  `TEACHINGEFFECTIVENESS7` varchar(255) DEFAULT NULL,
  `TEACHINGEFFECTIVENESS8` varchar(255) DEFAULT NULL,
  `CLASSROOMMANAGEMENT9` varchar(255) DEFAULT NULL,
  `CLASSROOMMANAGEMENT11` varchar(255) DEFAULT NULL,
  `CLASSROOMMANAGEMENT12` varchar(255) DEFAULT NULL,
  `CLASSROOMMANAGEMENT13` varchar(255) DEFAULT NULL,
  `CLASSROOMMANAGEMENT15` varchar(255) DEFAULT NULL,
  `STUDENTENGAGEMENT17` varchar(255) DEFAULT NULL,
  `STUDENTENGAGEMENT18` varchar(255) DEFAULT NULL,
  `STUDENTENGAGEMENT19` varchar(255) DEFAULT NULL,
  `STUDENTENGAGEMENT20` varchar(255) DEFAULT NULL,
  `STUDENTENGAGEMENT21` varchar(255) DEFAULT NULL,
  `COMMUNICATION22` varchar(255) DEFAULT NULL,
  `COMMUNICATION23` varchar(255) DEFAULT NULL,
  `COMMUNICATION24` varchar(255) DEFAULT NULL,
  `COMMUNICATION25` varchar(255) DEFAULT NULL,
  `COMMUNICATION26` varchar(255) DEFAULT NULL,
  `EMOTIONALCOMPETENCE27` varchar(255) DEFAULT NULL,
  `EMOTIONALCOMPETENCE28` varchar(255) DEFAULT NULL,
  `EMOTIONALCOMPETENCE29` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentsform`
--

INSERT INTO `studentsform` (`id`, `srcode`, `studentSection`, `toFacultyID`, `fromStudentID`, `subject`, `semester`, `academic_year`, `toFaculty`, `fromStudents`, `comment`, `date`, `TEACHINGEFFECTIVENESS3`, `TEACHINGEFFECTIVENESS4`, `TEACHINGEFFECTIVENESS5`, `TEACHINGEFFECTIVENESS6`, `TEACHINGEFFECTIVENESS7`, `TEACHINGEFFECTIVENESS8`, `CLASSROOMMANAGEMENT9`, `CLASSROOMMANAGEMENT11`, `CLASSROOMMANAGEMENT12`, `CLASSROOMMANAGEMENT13`, `CLASSROOMMANAGEMENT15`, `STUDENTENGAGEMENT17`, `STUDENTENGAGEMENT18`, `STUDENTENGAGEMENT19`, `STUDENTENGAGEMENT20`, `STUDENTENGAGEMENT21`, `COMMUNICATION22`, `COMMUNICATION23`, `COMMUNICATION24`, `COMMUNICATION25`, `COMMUNICATION26`, `EMOTIONALCOMPETENCE27`, `EMOTIONALCOMPETENCE28`, `EMOTIONALCOMPETENCE29`) VALUES
(29, '23-46378', 'IT-2102', 6, '', 'Computer Networking 1', 'FIRST', '2024-2025', 'Erwin De Castro', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquam ante nec sapien accumsan, quis lacinia lectus molestie. Aenean egestas justo sit amet nulla volutpat, ut scelerisque ligula volutpat.', '2024-11-22', '4', '5', '4', '5', '4', '5', '5', '4', '5', '5', '5', '4', '4', '4', '4', '5', '3', '4', '4', '4', '5', '5', '3', '3'),
(30, '23-46378', 'IT-2102', 23, '', 'Object-Oriented Programming', 'FIRST', '2024-2025', 'Michael Ramilo', '', 'Sed iaculis quam et dui porta bibendum. Vestibulum laoreet est quis sem lacinia congue. Curabitur feugiat placerat mollis. Aenean nec tempor nunc.', '2024-11-22', '4', '5', '4', '5', '4', '4', '5', '4', '3', '3', '3', '3', '4', '3', '4', '5', '3', '4', '5', '5', '4', '3', '4', '5'),
(31, '23-46378', 'IT-2102', 22, '', 'Individual and Dual Sports', 'FIRST', '2024-2025', 'Bryan Mondres', '', 'Morbi porta, ligula vel lacinia egestas, nunc metus consectetur justo, eget venenatis purus erat euismod nunc.', '2024-11-22', '3', '4', '5', '4', '3', '4', '3', '4', '5', '4', '3', '3', '4', '5', '4', '3', '3', '4', '5', '4', '5', '3', '4', '5'),
(32, '23-46378', 'IT-2102', 24, '', 'ASEAN Literature', 'FIRST', '2024-2025', 'Hazel Joy Banayo', '', 'Morbi ut lorem ac erat feugiat maximus. Sed malesuada mi consectetur quam fermentum, eget mattis neque pellentesque.', '2024-11-22', '4', '5', '4', '5', '5', '5', '3', '4', '3', '3', '3', '3', '4', '5', '4', '5', '3', '4', '3', '4', '5', '3', '4', '3'),
(33, '23-46378', 'IT-2102', 8, '', 'Database Management System', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Nunc non dui iaculis, rutrum purus id, pulvinar elit. Interdum et malesuada fames ac ante ipsum primis in faucibus.', '2024-11-22', '3', '4', '3', '3', '3', '3', '5', '4', '5', '5', '4', '3', '4', '4', '5', '5', '3', '4', '3', '4', '5', '2', '3', '5'),
(34, '23-46378', 'IT-2102', 19, '', 'Calculus-Based Physics', 'FIRST', '2024-2025', 'Jasmin Pesigan', '', 'Nullam consequat accumsan gravida. Donec non dui risus. Quisque feugiat semper eros, vel elementum est aliquet in.', '2024-11-22', '5', '4', '5', '5', '5', '5', '3', '4', '5', '4', '5', '3', '4', '4', '5', '4', '3', '4', '3', '4', '5', '3', '4', '5'),
(35, '23-46378', 'IT-2102', 21, '', 'Discrete Mathematics', 'FIRST', '2024-2025', 'Ariane Villanueva', '', 'Integer ac porttitor metus. In aliquam sed risus a semper. Ut viverra ante ac eros posuere, eget facilisis nibh dictum.', '2024-11-22', '3', '4', '3', '4', '5', '5', '3', '4', '4', '4', '5', '2', '3', '2', '3', '4', '3', '4', '4', '4', '5', '5', '4', '5'),
(36, '23-46379', 'IT-2102', 6, '', 'Computer Networking 1', 'FIRST', '2024-2025', 'Erwin De Castro', '', 'Duis quis urna quam. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Aliquam scelerisque dui at tellus vehicula faucibus. Donec interdum eleifend volutpat.', '2024-11-22', '3', '4', '5', '4', '5', '5', '4', '5', '4', '5', '5', '4', '5', '4', '5', '4', '3', '4', '4', '5', '4', '3', '4', '5'),
(37, '23-46379', 'IT-2102', 23, '', 'Object-Oriented Programming', 'FIRST', '2024-2025', 'Michael Ramilo', '', 'Sed iaculis ut nulla at gravida. Aliquam nec fermentum sapien. Curabitur ac ultricies nisl. Nunc a ante sed lacus lacinia rhoncus ut nec nisl. Vestibulum convallis ex ac finibus fringilla.', '2024-11-22', '3', '4', '3', '4', '5', '4', '3', '4', '5', '4', '5', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', '4', '5'),
(38, '23-46379', 'IT-2102', 22, '', 'Individual and Dual Sports', 'FIRST', '2024-2025', 'Bryan Mondres', '', 'Etiam et posuere quam. Nulla facilisi. Fusce volutpat convallis est, vitae porta tortor gravida eget. Sed volutpat erat eget erat porta', '2024-11-22', '2', '3', '3', '4', '5', '4', '5', '4', '3', '2', '3', '3', '4', '3', '4', '5', '2', '3', '4', '5', '4', '5', '4', '3'),
(39, '23-46379', 'IT-2102', 24, '', 'ASEAN Literature', 'FIRST', '2024-2025', 'Hazel Joy Banayo', '', 'Suspendisse eleifend vel arcu in viverra. Integer laoreet lorem sed ultrices vehicula. Suspendisse id tempus ipsum.', '2024-11-22', '5', '4', '3', '3', '3', '2', '1', '2', '3', '4', '5', '5', '4', '3', '2', '1', '2', '3', '3', '4', '5', '3', '4', '5'),
(40, '23-46379', 'IT-2102', 8, '', 'Database Management System', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Sed ullamcorper, dolor in porta lacinia, mauris augue maximus arcu, a pulvinar ipsum libero volutpat diam. Vestibulum vitae cursus risus.', '2024-11-22', '5', '4', '3', '2', '3', '4', '2', '3', '3', '4', '5', '2', '3', '4', '4', '5', '3', '4', '3', '4', '5', '3', '4', '5'),
(41, '23-46379', 'IT-2102', 19, '', 'Calculus-Based Physics', 'FIRST', '2024-2025', 'Jasmin Pesigan', '', 'Donec et mi metus. Donec scelerisque orci ac quam finibus laoreet.', '2024-11-22', '2', '3', '4', '5', '4', '3', '2', '3', '4', '3', '4', '2', '3', '4', '3', '5', '2', '3', '3', '4', '5', '5', '4', '5'),
(42, '23-46379', 'IT-2102', 21, '', 'Discrete Mathematics', 'FIRST', '2024-2025', 'Ariane Villanueva', '', 'Nulla non turpis porta, commodo enim nec, gravida nibh. Vivamus vehicula id enim sed ullamcorper.', '2024-11-22', '5', '4', '3', '4', '3', '4', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', '4', '5'),
(43, '23-46380', 'IT-2102', 6, '', 'Computer Networking 1', 'FIRST', '2024-2025', 'Erwin De Castro', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus arcu ex, ultricies eget varius non, ultrices at risus.', '2024-11-22', '4', '5', '4', '5', '4', '5', '1', '2', '3', '4', '5', '5', '4', '3', '2', '1', '5', '4', '3', '2', '1', '3', '4', '3'),
(44, '23-46380', 'IT-2102', 23, '', 'Object-Oriented Programming', 'FIRST', '2024-2025', 'Michael Ramilo', '', 'Donec tempus lobortis aliquet. Mauris sagittis, tortor non tristique condimentum, mi libero venenatis ligula, pharetra hendrerit metus neque sed ligula.', '2024-11-22', '1', '2', '3', '4', '5', '4', '5', '4', '5', '4', '5', '5', '4', '3', '2', '2', '3', '4', '3', '4', '5', '3', '4', '5'),
(45, '23-46380', 'IT-2102', 22, '', 'Individual and Dual Sports', 'FIRST', '2024-2025', 'Bryan Mondres', '', 'Ut sodales euismod elit in convallis. Curabitur at elit a mi pharetra malesuada id sit amet ante.', '2024-11-22', '5', '4', '3', '3', '3', '4', '3', '4', '3', '4', '3', '2', '3', '4', '5', '4', '3', '4', '5', '4', '3', '3', '4', '5'),
(46, '23-46380', 'IT-2102', 24, '', 'ASEAN Literature', 'FIRST', '2024-2025', 'Hazel Joy Banayo', '', 'Ut id efficitur nunc. Duis iaculis bibendum neque, et porta diam molestie pellentesque.', '2024-11-22', '5', '4', '5', '3', '3', '3', '2', '3', '4', '4', '5', '5', '4', '3', '4', '2', '3', '4', '3', '4', '5', '3', '4', '5'),
(47, '23-46380', 'IT-2102', 8, '', 'Database Management System', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Aliquam rhoncus congue purus, sed ultrices nunc dictum sed.', '2024-11-22', '1', '1', '2', '3', '4', '5', '1', '2', '3', '4', '5', '1', '2', '3', '4', '5', '1', '2', '3', '4', '5', '1', '2', '3'),
(48, '23-46380', 'IT-2102', 19, '', 'Calculus-Based Physics', 'FIRST', '2024-2025', 'Jasmin Pesigan', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eu nisi sed magna tempus accumsan eu a augue. Nunc in vehicula augue, sit amet tempus ex.', '2024-11-22', '1', '2', '3', '4', '3', '2', '4', '2', '1', '2', '1', '5', '5', '5', '5', '5', '2', '3', '2', '3', '4', '3', '4', '5'),
(49, '23-46380', 'IT-2102', 21, '', 'Discrete Mathematics', 'FIRST', '2024-2025', 'Ariane Villanueva', '', 'Maecenas id ex id magna finibus luctus id non neque. Pellentesque convallis mauris elementum nisi pretium, id hendrerit ligula rutrum.', '2024-11-22', '5', '4', '5', '4', '3', '2', '5', '4', '5', '4', '3', '3', '4', '5', '4', '2', '2', '3', '4', '5', '4', '3', '4', '3'),
(50, '23-46382', 'IT-2102', 6, '', 'Computer Networking 1', 'FIRST', '2024-2025', 'Erwin De Castro', '', 'Aliquam erat volutpat. Suspendisse leo massa, vulputate ut luctus et, sagittis id libero. Duis ut lacus nec nunc finibus consequat.', '2024-11-22', '2', '3', '5', '4', '5', '5', '5', '4', '5', '4', '5', '3', '4', '5', '4', '3', '3', '4', '3', '4', '5', '3', '4', '3'),
(51, '23-46382', 'IT-2102', 23, '', 'Object-Oriented Programming', 'FIRST', '2024-2025', 'Michael Ramilo', '', 'Proin hendrerit sed ipsum rhoncus commodo. Nam iaculis ac nibh vel placerat. Donec porttitor odio vel orci scelerisque, sed facilisis quam imperdiet.', '2024-11-22', '1', '2', '3', '4', '5', '4', '2', '3', '3', '4', '5', '3', '4', '3', '4', '3', '2', '3', '4', '3', '4', '2', '3', '5'),
(52, '23-46382', 'IT-2102', 22, '', 'Individual and Dual Sports', 'FIRST', '2024-2025', 'Bryan Mondres', '', 'Aliquam vitae consequat enim. Aliquam erat volutpat. Pellentesque id quam ut ipsum tempus blandit viverra vitae risus.', '2024-11-22', '2', '3', '4', '3', '4', '5', '2', '3', '3', '4', '5', '3', '4', '3', '4', '3', '2', '3', '4', '3', '4', '2', '3', '4'),
(53, '23-46382', 'IT-2102', 24, '', 'ASEAN Literature', 'FIRST', '2024-2025', 'Hazel Joy Banayo', '', 'Etiam id sagittis leo, nec elementum orci. Nulla facilisi. Phasellus in tellus a dolor dictum finibus.', '2024-11-22', '3', '3', '4', '3', '4', '5', '2', '3', '4', '5', '3', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', '4', '2'),
(54, '23-46382', 'IT-2102', 8, '', 'Database Management System', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Nunc at nisi a nibh venenatis varius et eu erat. Curabitur vitae sodales lorem. Donec egestas orci augue, ut gravida tortor interdum a.', '2024-11-22', '1', '2', '3', '2', '3', '4', '2', '3', '2', '3', '3', '5', '4', '3', '2', '4', '3', '4', '2', '3', '4', '5', '3', '2'),
(55, '23-46382', 'IT-2102', 19, '', 'Calculus-Based Physics', 'FIRST', '2024-2025', 'Jasmin Pesigan', '', 'Mauris augue tellus, viverra sit amet vestibulum eget, hendrerit sit amet quam. Integer vel arcu in nibh vestibulum viverra malesuada eget neque.', '2024-11-22', '2', '3', '4', '4', '2', '3', '3', '4', '3', '4', '4', '2', '3', '4', '5', '3', '3', '4', '3', '4', '5', '2', '3', '4'),
(56, '23-46382', 'IT-2102', 21, '', 'Discrete Mathematics', 'FIRST', '2024-2025', 'Ariane Villanueva', '', 'Ut quis odio ac diam mattis condimentum et in nisi. Vestibulum imperdiet quam ut consequat vestibulum. Aenean arcu arcu, vehicula at feugiat at, suscipit a eros. Praesent in quam orci.', '2024-11-22', '2', '3', '3', '4', '5', '4', '5', '4', '3', '2', '2', '2', '3', '2', '3', '4', '3', '4', '3', '4', '5', '3', '4', '5'),
(57, '23-46384', 'IT-2102', 6, '', 'Computer Networking 1', 'FIRST', '2024-2025', 'Erwin De Castro', '', 'Nunc eleifend risus quis sapien venenatis, sit amet sagittis turpis convallis. Integer tristique lacus vel velit tempus, vitae ultrices nibh dignissim.', '2024-11-22', '2', '3', '4', '3', '4', '5', '2', '3', '4', '5', '4', '2', '3', '4', '5', '3', '3', '4', '5', '4', '2', '3', '4', '4'),
(58, '23-46384', 'IT-2102', 23, '', 'Object-Oriented Programming', 'FIRST', '2024-2025', 'Michael Ramilo', '', 'Curabitur hendrerit mi sollicitudin ante volutpat accumsan.', '2024-11-22', '5', '3', '4', '2', '4', '4', '4', '3', '4', '3', '2', '2', '3', '4', '5', '4', '5', '4', '4', '3', '2', '4', '3', '2'),
(59, '23-46384', 'IT-2102', 22, '', 'Individual and Dual Sports', 'FIRST', '2024-2025', 'Bryan Mondres', '', 'Cras libero nibh, mollis et pharetra ut, maximus dignissim odio.', '2024-11-22', '3', '4', '5', '4', '3', '2', '2', '3', '4', '5', '4', '4', '5', '4', '3', '2', '3', '4', '5', '4', '3', '3', '4', '3'),
(60, '23-46384', 'IT-2102', 24, '', 'ASEAN Literature', 'FIRST', '2024-2025', 'Hazel Joy Banayo', '', 'Maecenas venenatis ex vitae massa tristique, non ultrices sem pulvinar.', '2024-11-22', '3', '4', '5', '4', '3', '4', '4', '5', '4', '5', '4', '4', '3', '4', '5', '4', '4', '5', '5', '5', '5', '3', '3', '3'),
(61, '23-46384', 'IT-2102', 8, '', 'Database Management System', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Maecenas justo felis, vestibulum non auctor et, condimentum ut arcu.', '2024-11-22', '4', '5', '4', '1', '4', '2', '4', '5', '4', '3', '2', '4', '4', '4', '4', '4', '5', '5', '5', '5', '5', '4', '3', '2'),
(62, '23-46384', 'IT-2102', 19, '', 'Calculus-Based Physics', 'FIRST', '2024-2025', 'Jasmin Pesigan', '', 'In hac habitasse platea dictumst. Mauris placerat mauris a tristique ullamcorper. Proin a consequat eros.', '2024-11-22', '4', '4', '5', '4', '5', '4', '3', '4', '5', '4', '3', '3', '4', '5', '4', '3', '3', '4', '5', '4', '4', '5', '4', '5'),
(63, '23-46384', 'IT-2102', 21, '', 'Discrete Mathematics', 'FIRST', '2024-2025', 'Ariane Villanueva', '', 'Nam nec eleifend magna. Fusce sollicitudin vitae metus nec tristique.', '2024-11-22', '4', '4', '5', '4', '5', '4', '3', '4', '5', '4', '3', '3', '4', '5', '4', '5', '3', '4', '5', '4', '3', '3', '4', '5'),
(64, '22-46378', 'ITBA-3101', 1, '', 'Fundamentals of Business Analytics', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vel lobortis felis.', '2024-11-23', '3', '4', '3', '4', '5', '3', '2', '3', '4', '5', '4', '2', '3', '4', '5', '4', '3', '4', '3', '4', '3', '3', '4', '5'),
(65, '22-46378', 'ITBA-3101', 1, '', 'Fundamentals of Analytics Modeling', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Pellentesque vitae felis nec nisl efficitur semper.', '2024-11-23', '3', '3', '4', '4', '5', '4', '2', '3', '2', '3', '2', '2', '3', '4', '5', '3', '3', '4', '3', '5', '3', '3', '4', '5'),
(66, '22-46378', 'ITBA-3101', 5, '', 'Ethics', 'FIRST', '2024-2025', 'Eddie Jr. Bucad', '', 'Suspendisse consectetur leo mauris, sit amet suscipit diam rhoncus quis. Sed nec eleifend lorem.', '2024-11-23', '5', '4', '3', '2', '3', '4', '3', '4', '5', '4', '2', '3', '4', '5', '5', '4', '3', '4', '5', '4', '3', '5', '4', '2'),
(67, '22-46378', 'ITBA-3102', 8, '', 'Web Systems and Technologies', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Pellentesque a auctor velit, vitae sodales nisl.', '2024-11-23', '1', '2', '3', '4', '3', '5', '3', '4', '3', '4', '5', '3', '4', '5', '5', '5', '5', '4', '3', '3', '3', '4', '5', '4'),
(68, '22-46378', 'ITBA-3102', 10, '', 'System Analysis and Design', 'FIRST', '2024-2025', 'Menard Canoy', '', 'Ut velit turpis, euismod sit amet arcu at, efficitur cursus felis.', '2024-11-23', '1', '2', '3', '2', '3', '5', '3', '4', '3', '4', '5', '2', '3', '4', '5', '4', '2', '3', '4', '5', '3', '3', '4', '5'),
(69, '22-46378', 'ITBA-3102', 11, '', 'Systems Integration and Architecture', 'FIRST', '2024-2025', 'Cruzette Calzo', '', 'raesent placerat justo leo, sed porttitor elit pharetra ac.', '2024-11-23', '1', '2', '2', '2', '3', '5', '2', '3', '4', '5', '3', '2', '3', '4', '3', '4', '3', '4', '3', '4', '5', '3', '4', '5'),
(70, '22-46379', 'ITBA-3101', 1, '', 'Fundamentals of Business Analytics', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Aenean quis nunc et risus efficitur fringilla a cursus erat.', '2024-11-23', '2', '3', '4', '5', '4', '4', '5', '4', '3', '2', '3', '3', '4', '5', '4', '5', '3', '4', '5', '5', '5', '5', '3', '2'),
(71, '22-46379', 'ITBA-3101', 1, '', 'Fundamentals of Analytics Modeling', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Morbi tristique, augue quis facilisis commodo, orci lorem posuere velit, sit amet dictum sem felis id orci.', '2024-11-23', '5', '4', '3', '2', '3', '4', '2', '3', '4', '5', '4', '4', '5', '4', '5', '4', '2', '3', '4', '5', '4', '3', '4', '5'),
(72, '22-46379', 'ITBA-3101', 5, '', 'Ethics', 'FIRST', '2024-2025', 'Eddie Jr. Bucad', '', 'Maecenas ultricies et quam vitae porta. Nullam rutrum ut odio id ullamcorper.', '2024-11-23', '3', '4', '3', '4', '5', '4', '3', '4', '3', '4', '5', '2', '3', '4', '3', '4', '3', '4', '3', '4', '5', '3', '4', '5'),
(73, '22-46379', 'ITBA-3102', 8, '', 'Web Systems and Technologies', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Fusce non nibh sit amet ante blandit dictum id quis velit.', '2024-11-23', '2', '3', '4', '4', '4', '5', '3', '4', '3', '4', '5', '3', '4', '5', '4', '5', '5', '4', '5', '4', '3', '4', '5', '4'),
(74, '22-46379', 'ITBA-3102', 10, '', 'System Analysis and Design', 'FIRST', '2024-2025', 'Menard Canoy', '', 'Sed accumsan nisi at turpis dignissim, nec sollicitudin diam luctus.', '2024-11-23', '1', '2', '3', '3', '3', '4', '5', '4', '3', '4', '3', '3', '4', '5', '4', '3', '3', '4', '5', '4', '5', '5', '4', '3'),
(75, '22-46379', 'ITBA-3102', 11, '', 'Systems Integration and Architecture', 'FIRST', '2024-2025', 'Cruzette Calzo', '', 'Ut erat augue, efficitur sit amet mi sit amet, consectetur volutpat purus.', '2024-11-23', '2', '3', '4', '5', '4', '5', '5', '4', '3', '4', '5', '5', '4', '3', '3', '4', '3', '4', '5', '4', '5', '5', '4', '5'),
(76, '22-46380', 'ITBA-3101', 1, '', 'Fundamentals of Business Analytics', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Duis varius erat vitae dignissim molestie. Aliquam erat volutpat.', '2024-11-23', '3', '4', '3', '4', '5', '4', '5', '4', '3', '4', '4', '3', '4', '4', '4', '5', '3', '4', '5', '4', '3', '3', '4', '3'),
(77, '22-46380', 'ITBA-3101', 1, '', 'Fundamentals of Analytics Modeling', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Mauris lorem orci, vehicula sit amet sodales at, ullamcorper at mauris. Cras id metus dolor.', '2024-11-23', '4', '5', '4', '3', '4', '4', '3', '4', '3', '4', '5', '3', '4', '5', '4', '5', '5', '4', '3', '4', '3', '3', '4', '5'),
(78, '22-46380', 'ITBA-3101', 5, '', 'Ethics', 'FIRST', '2024-2025', 'Eddie Jr. Bucad', '', 'Sed auctor ligula vel odio finibus, sed feugiat dolor convallis.', '2024-11-23', '3', '4', '3', '4', '3', '4', '5', '4', '3', '4', '5', '3', '4', '4', '4', '5', '3', '4', '4', '5', '4', '3', '4', '3'),
(79, '22-46380', 'ITBA-3102', 8, '', 'Web Systems and Technologies', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Mauris non orci id ante pulvinar lacinia. Morbi neque quam, finibus in eros venenatis, venenatis cursus quam.', '2024-11-23', '3', '4', '4', '5', '4', '5', '3', '4', '3', '3', '4', '3', '4', '4', '5', '4', '3', '4', '3', '4', '5', '5', '4', '5'),
(80, '22-46380', 'ITBA-3102', 10, '', 'System Analysis and Design', 'FIRST', '2024-2025', 'Menard Canoy', '', 'Integer bibendum urna lorem, mollis viverra augue tincidunt in.', '2024-11-23', '3', '4', '3', '4', '5', '4', '4', '5', '4', '5', '4', '5', '4', '3', '4', '4', '5', '4', '3', '4', '3', '3', '4', '5'),
(81, '22-46380', 'ITBA-3102', 11, '', 'Systems Integration and Architecture', 'FIRST', '2024-2025', 'Cruzette Calzo', '', 'Integer egestas urna nisl.', '2024-11-23', '3', '3', '4', '4', '5', '4', '3', '4', '3', '4', '5', '5', '4', '3', '4', '3', '3', '4', '5', '4', '5', '4', '4', '4'),
(82, '22-46381', 'ITBA-3101', 1, '', 'Fundamentals of Business Analytics', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Curabitur at odio et quam interdum ullamcorper a eget est.', '2024-11-23', '2', '3', '3', '2', '3', '3', '4', '3', '4', '5', '4', '3', '4', '3', '4', '5', '3', '4', '3', '4', '3', '3', '4', '3'),
(83, '22-46381', 'ITBA-3101', 1, '', 'Fundamentals of Analytics Modeling', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Sed erat orci, laoreet ut lacus bibendum, ullamcorper ornare ligula.', '2024-11-23', '3', '3', '4', '3', '4', '3', '4', '3', '4', '5', '3', '3', '3', '4', '3', '5', '3', '3', '4', '3', '4', '4', '5', '4'),
(84, '22-46381', 'ITBA-3101', 5, '', 'Ethics', 'FIRST', '2024-2025', 'Eddie Jr. Bucad', '', 'Quisque eu suscipit urna. Nulla et massa leo.', '2024-11-23', '5', '4', '3', '4', '3', '4', '3', '4', '4', '4', '5', '5', '4', '3', '3', '4', '3', '4', '4', '5', '3', '3', '3', '5'),
(85, '22-46381', 'ITBA-3102', 8, '', 'Web Systems and Technologies', 'FIRST', '2024-2025', 'Mary Jean Abejuela', '', 'Morbi sagittis commodo elit in fringilla.', '2024-11-23', '3', '3', '4', '3', '4', '5', '3', '3', '4', '4', '5', '3', '3', '4', '3', '4', '5', '4', '3', '4', '5', '2', '3', '3'),
(86, '22-46381', 'ITBA-3102', 10, '', 'System Analysis and Design', 'FIRST', '2024-2025', 'Menard Canoy', '', 'Morbi blandit nunc vitae mi consectetur accumsan non at libero.', '2024-11-23', '1', '2', '2', '3', '3', '4', '3', '3', '4', '3', '4', '5', '4', '3', '3', '4', '3', '3', '4', '4', '5', '5', '4', '5'),
(87, '22-46381', 'ITBA-3102', 11, '', 'Systems Integration and Architecture', 'FIRST', '2024-2025', 'Cruzette Calzo', '', 'Sed porttitor nisi sed pretium auctor.', '2024-11-23', '3', '3', '4', '4', '5', '4', '5', '4', '3', '3', '3', '4', '4', '4', '5', '4', '3', '3', '3', '4', '5', '5', '4', '3'),
(88, '22-46394', 'ITBA-3103', 1, '', 'Fundamentals of Analytics Modeling', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'TEST', '2024-11-23', '2', '3', '4', '3', '4', '5', '2', '3', '4', '5', '3', '2', '3', '3', '4', '5', '3', '4', '3', '4', '3', '4', '5', '3'),
(89, '22-46397', 'ITBA-3103', 1, '', 'Fundamentals of Analytics Modeling', 'FIRST', '2024-2025', 'Shiela Marie Garcia', '', 'Test', '2024-11-24', '1', '2', '3', '4', '4', '5', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', '4', '3', '4', '5', '3', '4', '5');

--
-- Triggers `studentsform`
--
DELIMITER $$
CREATE TRIGGER `calculate_averages` AFTER INSERT ON `studentsform` FOR EACH ROW BEGIN
    DECLARE teaching_avg DECIMAL(10, 2);
    
    -- Calculate the average of the teaching effectiveness columns
    SET teaching_avg = (NEW.TEACHINGEFFECTIVENESS3 + NEW.TEACHINGEFFECTIVENESS4 + NEW.TEACHINGEFFECTIVENESS5 +
                        NEW.TEACHINGEFFECTIVENESS6 + NEW.TEACHINGEFFECTIVENESS7 + NEW.TEACHINGEFFECTIVENESS8) / 6;

    -- Insert the calculated averages into the average_ratings table
    INSERT INTO average_ratings (teaching_average)
    VALUES (teaching_avg);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `student_basic_info`
--

CREATE TABLE `student_basic_info` (
  `id` int(11) NOT NULL,
  `sr_code` varchar(20) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_basic_info`
--

INSERT INTO `student_basic_info` (`id`, `sr_code`, `lastname`, `firstname`, `middlename`) VALUES
(23, '23-46378', 'Johnson', 'Ava', 'Santos'),
(24, '23-46379', 'Williams', 'Liam', 'Vera'),
(25, '23-46380', 'Davis', 'Noah', ''),
(26, '23-46382', 'Rodriguez', 'Mia', ''),
(27, '23-46383', 'Lee', 'Ethan', ''),
(28, '23-46384', 'Wilson', 'Sophia', ''),
(29, '23-46385', 'Clark', 'Mason', ''),
(30, '23-46386', 'Harris', 'Emily', ''),
(31, '23-46387', 'Lewis', 'Oliver', ''),
(32, '23-46388', 'Hall', 'Charlotte', ''),
(33, '23-46389', 'Martinez', 'Lucas', ''),
(34, '23-46390', 'Young', 'Grace', ''),
(35, '23-46391', 'Walker', 'Henry', ''),
(36, '23-46392', 'King', 'Ella', ''),
(37, '23-46393', 'Scott', 'Benjamin', ''),
(38, '23-46394', 'Adams', 'Lily', ''),
(39, '23-46395', 'Nelson', 'Samuel', ''),
(40, '23-46396', 'Carter', 'Zoey', ''),
(41, '23-46397', 'Wright', 'Daniel', ''),
(42, '23-46398', 'Reed', 'Natalie', ''),
(43, '23-46399', 'Rivera', 'Anthony', ''),
(44, '23-46400', 'Mitchell', 'Scarlett', ''),
(45, '23-46401', 'Perez', 'Jack', ''),
(46, '23-46402', 'Sanchez', 'Victoria', ''),
(47, '23-46403', 'Hill', 'Christopher', ''),
(48, '23-46404', 'Long', 'Hannah', ''),
(49, '23-46405', 'Baker', 'Nathan', ''),
(50, '23-46406', 'Cooper', 'Ella', ''),
(51, '23-46407', 'Morgan', 'Ryan', ''),
(52, '23-46408', 'Bell', 'Addison', ''),
(53, '23-46409', 'Murphy', 'Aiden', ''),
(54, '23-46410', 'Lee', 'Chloe', ''),
(55, '23-46411', 'Green', 'Lucas', ''),
(56, '23-46412', 'Scott', 'Layla', ''),
(57, '23-46413', 'Turner', 'Jason', ''),
(58, '23-46414', 'Rivera', 'Sofia', ''),
(59, '19-63308', 'Mike', 'Test', ''),
(60, '22-46378', 'Johnson', 'Samuel', ''),
(61, '22-46379', 'Garcia', 'Olivia', ''),
(62, '22-46380', 'Wilson', 'Ethan', ''),
(63, '22-46381', 'White', 'Charlotte', ''),
(64, '22-46382', 'Martinez', 'Noah', ''),
(65, '22-46383', 'Robinson', 'Mia', ''),
(66, '22-46384', 'Thompson', 'Jacob', ''),
(67, '22-46385', 'Johnson', 'Lily', ''),
(68, '22-46386', 'Lee', 'Lucas', ''),
(69, '22-46387', 'Harris', 'Benjamin', ''),
(70, '22-46388', 'Foster', 'Emma', ''),
(71, '22-46389', 'Young', 'Oliver', ''),
(72, '22-46390', 'Wright', 'Grace', ''),
(73, '22-46391', 'Hall', 'Aiden', ''),
(74, '22-46392', 'Lewis', 'Sophia', ''),
(75, '22-46393', 'Scott', 'Alexander', ''),
(76, '22-46394', 'Carter', 'Hannah', ''),
(77, '22-46395', 'Hall', 'Daniel', ''),
(78, '22-46396', 'Green', 'Layla', ''),
(79, '22-46397', 'Baker', 'Ryan', ''),
(80, '24-46378', 'Smith', 'Emma', ''),
(81, '22-01234', 'test', 'test', 'test'),
(82, '22-00941', 'rets', 'ret', 'ret');

-- --------------------------------------------------------

--
-- Table structure for table `student_major`
--

CREATE TABLE `student_major` (
  `id` int(11) NOT NULL,
  `sr_code` varchar(30) NOT NULL,
  `major` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_major`
--

INSERT INTO `student_major` (`id`, `sr_code`, `major`) VALUES
(17, '19-63308', 'Business Analytics'),
(18, '22-46378', 'Business Analytics'),
(19, '22-46379', 'Business Analytics'),
(20, '22-46380', 'Business Analytics'),
(21, '22-46381', 'Business Analytics'),
(22, '22-46382', 'Business Analytics'),
(23, '22-46396', 'Business Analytics'),
(24, '22-46394', 'Business Analytics'),
(30, '22-46397', 'Business Analytics'),
(31, '22-46391', 'Business Analytics');

-- --------------------------------------------------------

--
-- Table structure for table `student_status`
--

CREATE TABLE `student_status` (
  `id` int(11) NOT NULL,
  `sr_code` varchar(20) NOT NULL,
  `year_level` varchar(20) NOT NULL,
  `status_id` int(11) NOT NULL,
  `section` varchar(20) NOT NULL,
  `course` varchar(100) NOT NULL,
  `sem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_status`
--

INSERT INTO `student_status` (`id`, `sr_code`, `year_level`, `status_id`, `section`, `course`, `sem_id`) VALUES
(23, '23-46378', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(24, '23-46379', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(25, '23-46380', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(26, '23-46382', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(27, '23-46383', '1', 1, '0', 'Bachelor of Science in Information Technology', 1),
(28, '23-46384', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(29, '23-46385', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(30, '23-46386', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(31, '23-46387', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(32, '23-46388', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(33, '23-46389', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(34, '23-46390', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(35, '23-46391', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(36, '23-46392', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(37, '23-46393', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(38, '23-46394', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(39, '23-46395', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(40, '23-46396', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(41, '23-46397', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(42, '23-46398', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(43, '23-46399', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(44, '23-46400', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(45, '23-46401', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(46, '23-46402', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(47, '23-46403', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(48, '23-46404', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(49, '23-46405', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(50, '23-46406', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(51, '23-46407', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(52, '23-46408', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(53, '23-46409', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(54, '23-46410', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(55, '23-46411', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(56, '23-46412', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(57, '23-46413', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(58, '23-46414', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(59, '19-63308', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(60, '22-46378', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(61, '22-46379', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(62, '22-46380', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(63, '22-46381', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(64, '22-46382', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(65, '22-46383', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(66, '22-46384', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(67, '22-46385', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(68, '22-46386', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(69, '22-46387', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(70, '22-46388', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(71, '22-46389', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(72, '22-46390', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(73, '22-46391', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(74, '22-46392', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(75, '22-46393', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(76, '22-46394', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(77, '22-46395', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(78, '22-46396', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(79, '22-46397', '3', 1, '0', 'Bachelor of Science in Information Technology', 1),
(80, '24-46378', '1', 1, '0', 'Bachelor of Science in Information Technology', 1),
(81, '22-01234', '2', 1, '0', 'Bachelor of Science in Information Technology', 1),
(82, '22-00941', '1', 1, '0', 'Bachelor of Science in Information Technology', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject` varchar(75) NOT NULL,
  `unit` int(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `subject_code` varchar(30) NOT NULL,
  `major` varchar(100) DEFAULT NULL,
  `linkOne` text NOT NULL,
  `linkTwo` text NOT NULL,
  `linkThree` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject`, `unit`, `year`, `semester`, `subject_code`, `major`, `linkOne`, `linkTwo`, `linkThree`) VALUES
(1, 'Capstone Project 2', 3, '4', '1', 'IT 411', NULL, 'https://www.youtube.com/results?search_query=capstone+2+reommendation', '', ''),
(2, 'Capstone Project 1', 3, '3', '2', 'IT 324', NULL, '', '', ''),
(4, 'Introduction to Computing', 3, '1', '1', 'IT 111', NULL, 'https://www.coursera.org/learn/mathematical-thinking , https://youtube.com/playlist?list=PLPPsDIdbG32Auf61Nq_mFwIe7Xel3VfsW&si=HrmZS_aWJhBQOFoo', 'Recommendation Link', ''),
(6, 'Social Issues and Professional Practice', 3, '4', '1', 'CS 423', NULL, 'https://www.acm.org/code-of-ethics', '', ''),
(7, 'Principles of System Thinking', 3, '4', '1', 'SMT 405', 'Service Management', '', '', ''),
(8, 'Advanced Information Assurance and Security', 3, '4', '1', 'IT 413', NULL, 'https://www.csoonline.com/article/567457/what-is-the-cisa-how-the-new-federal-agency-protects-critical-infrastructure-from-cyber-', '', ''),
(9, 'Platform Technologies', 3, '4', '1', 'IT 412', NULL, 'https://www.youtube.com/watch?v=daQoVUA0wD8&list=PLZe8EjeorSMch4TCyL29C7VVh4-E_KB74', '', ''),
(10, 'Technopreneurship', 3, '4', '1', 'ENGG 405', NULL, 'https://timreview.ca/article/520#:~:text=What%20distinguishes%20technology%20entrepreneurship%20from%20other%20entrepreneurship%20types,technological%20knowledge%20and%20the%20firm%E2%80%99s%20asset%20ownership%20rights', 'https://www.ciit.edu.ph/what-is-technopreneurship-meaning-and-examples/', ''),
(11, 'IT Internship Training', 6, '4', '2', 'IT 421', NULL, '', '', ''),
(12, 'Systems Quality Assurance', 3, '4', '1', 'IT 414', NULL, 'https://www.youtube.com/watch?v=v3Qxf1PG0fo&list=PLfw_nI4u_6WM8200HlderALoIYKpSa4W6', 'https://www.tricentis.com/blog/64-essential-testing-metrics-for-measuring-quality-assurance-success', ''),
(13, 'Advanced Systems Integration and Architecture', 3, '3', '2', 'IT 322', NULL, 'https://www.studocu.com/ph/course/sti-college/advanced-systems-integration-and-architecture/5072959///https://ocw.mit.edu/courses/esd-342-advanced-system-architecture-spring-2006', 'https://www.coursera.org/specializations/software-design-architecture', 'https://incose.onlinelibrary.wiley.com/doi/abs/10.1002/%28SICI%291520-6858%281998%291%3A3%3C176%3A%3AAID-SYS3%3E3.0.CO%3B2-L'),
(14, 'Fundamentals of Business Process Outsourcing 2', 3, '3', '2', 'SMT 403', 'Service Management', '', '', ''),
(15, 'Human-Computer Interaction', 3, '3', '2', 'IT 321', NULL, 'https://www.interaction-design.org/literature/topics/user-centered-design', 'https://www.youtube.com/watch?v=EslYwlidqU4', 'https://www.simplilearn.com/what-is-human-computer-interaction-article/// https://www.interaction-design.org/literature/book/the-encyclopedia-of-human-computer-interaction-2nd-ed/human-computer-interaction-brief-intro'),
(16, 'Information Assurance and Security', 3, '3', '2', 'IT 323', NULL, '', '', ''),
(17, 'IT Project Management', 3, '3', '2', 'IT 325', NULL, 'https://www.manageengine.com/products/service-desk/itsm/it-project-management-software.html?network=o&device=c&keyword=it%20project%20management&campaignid=401291226&creative=&matchtype=e&adposition=&placement=&adgroup=1311717622046927&targetid=kwd-81982498615774:loc-149&location=145643&searchterm=IT%20Project%20Management&msclkid=a69d97068c2619413cdcf000df67e8f8&utm_source=bing&utm_medium=cpc&utm_campaign=SDP-Search-APAC-L1-Exact&utm_term=it%20project%20management&utm_content=Project%20Management///https://www.coursera.org/learn/copy-of-project-management-essentials///https://www.coursera.org/learn/project-management-foundations', 'https://www.slideshare.net/slideshow/introduction-to-emerging-technology-249882172/249882172', 'https://www.slideshare.net/slideshow/introduction-to-emerging-technology-249882172/249882172v=2_BHw3Jtw8E'),
(18, 'Service Culture', 3, '3', '2', 'SMT 404', 'Service Management', '', '', ''),
(19, 'Business Communication', 3, '3', '1', 'SMT 402', 'Service Management', '', '', ''),
(20, 'Ethics', 3, '3', '1', 'GEd 107', NULL, 'https://www.coursera.org/learn/environmental-management-ethics', 'https://www.coursera.org/learn/ethics-technology-engineering', 'https://www.coursera.org/learn/media-ethics-governance'),
(21, 'System Analysis and Design', 3, '3', '1', 'IT 313', NULL, 'https://www.tutorialspoint.com/system_analysis_and_design/index.html', 'https://www.geeksforgeeks.org/system-analysis-system-design', 'https://www.coursera.org/learn/analysis-for-business-systems'),
(22, 'Systems Administration and Maintenance', 3, '3', '1', 'IT 311', NULL, 'https://www.coursera.org/learn/system-administration-it-infrastructure-services', 'https://www.udemy.com/course/beginning-windows-system-administration/?couponCode=LETSLEARNNOWPP', 'https://www.classcentral.com/subject/system-administration'),
(23, 'Systems Integration and Architecture', 3, '3', '1', 'IT 312', NULL, 'https://www.studocu.com/ph/course/sti-college/advanced-systems-integration-and-architecture/5072959', 'https://www.coursera.org/specializations/software-design-architecture', 'https://incose.onlinelibrary.wiley.com/doi/abs/10.1002/%28SICI%291520-6858%281998%291%3A3%3C176%3A%3AAID-SYS3%3E3.0.CO%3B2-L'),
(24, 'Web Systems and Technologies', 3, '3', '1', 'IT 314', NULL, 'https://www.coursera.org/specializations/web-design///https://www.coursera.org/specializations/codio-web-tech-security', '', ''),
(25, 'Advanced Database Management System', 3, '2', '2', 'IT 222', NULL, 'https://www.coursera.org/projects/advanced-rdb-sql', 'https://www.udemy.com/course/advanced-database-administration/?utm_source=adwords&utm_medium=udemyads&utm_campaign=Search_DSA_Alpha_Prof_la.EN_cc.ROW-English&campaigntype=Search&portfolio=ROW-English&language=EN&product=Course&test=&audience=DSA&topic=SQL&priority=Alpha&utm_content=deal4584&utm_term=_._ag_162511579124_._ad_696197165277_._kw__._de_c_._dm__._pl__._ti_dsa-1705455364964_._li_9207398_._pd__._&matchtype=&gad_source=2&gclid=Cj0KCQjwjY64BhCaARIsAIfc7YYMM5bKO03gZcl1U4a4q8khrJElTbTnnWOJX6HmIA65GKnJ-FfhtMcaApfHEALw_wcB&couponCode=2021PM25', 'https://youtube.com/playlist?list=PLLANTs44t4TVFZ6i8fIu0wOBv3FVUMc89&si=hwE55kxF2I0xnAxH '),
(26, 'Computer Networking 2', 3, '2', '2', 'IT 223', NULL, 'https://youtube.com/playlist?list=PLLJXhnhyaJU-TenJ7hN5GHuhDUP1Q1a6w&si=vlVm5cf0PKg_1wEh', '', ''),
(27, 'Data Analysis', 3, '2', '2', 'MATH 408', NULL, 'https://www.coursera.org/specializations/data-analysis-visualization-foundations', '', ''),
(28, 'Environmental Sciences', 3, '2', '2', 'ES 101', NULL, 'https://www.coursera.org/searchquery=environmental%20science', 'https://youtube.com/playlist?list=PLIC0i9IRboHb19v2dF0yuenG7xDOGJLeP&si=qpoAjZXqnidrU63Y', ''),
(29, 'Information Management', 3, '2', '2', 'IT 221', NULL, 'https://youtu.be/jPlIMLTKfWo?si=oiQLfiT_kfO9Jx1D', '', ''),
(30, 'Purposive Communication', 3, '2', '2', 'GEd 106', NULL, 'https://youtube.com/playlist?list=PLE4sbRQzwEC0jG4SZKuFj7Fb9yjTMwfb7&si=m2lENAU3v9TVWVUH', '', ''),
(31, 'Team Sports', 2, '2', '2', 'PE 104', NULL, 'https://youtube.com/playlist?list=PL5pSUbaFuoaOIuMkZjRF_vZz2kx_2TKkJ&si=nNHm-4q5HV4u_ntm', '', ''),
(32, 'Understanding the Self', 3, '2', '2', 'GEd 101', NULL, 'https://youtube.com/playlist?list=PLp7eFNpHXcvCIAWPWLK7H_TaUc2Uakhwn&si=kn9XvC0jXSnxGMPF', '', ''),
(33, 'Advanced Computer Programming', 3, '2', '1', 'CS 121', NULL, 'https://www.coursera.org/specializations/python-3-programming', 'https://www.coursera.org/learn/programming-in-python , https://youtu.be/_uQrJ0TkZlc?si=tFiLJsE1lNS7pqUj', ''),
(34, 'ASEAN Literature', 3, '2', '1', 'Litr 102', NULL, 'https://youtube.com/playlist?list=PLHAaaIP6OJ3oNncxVU8x8WA96I9HdAnE7&si=7mgkOwS8F9oxQSGO', '', ''),
(35, 'Calculus-Based Physics', 3, '2', '1', 'Phy 101', NULL, 'https://youtube.com/playlist?list=PLFiWVa3Q_XmGPBQCAvBYimyvErKJIoLLj&si=2Z0EPQANzfl8wtsJ', '', ''),
(36, 'Computer Networking 1', 3, '2', '1', 'IT 212', NULL, 'https://youtu.be/vOEJqFWLT70?si=FkHy0_3V4wTgbfCd', '', ''),
(37, 'Database Management System', 3, '2', '1', 'IT 211', NULL, 'https://www.coursera.org/learn/database-management', 'https://www.coursera.org/learn/database-structures-and-management-with-mysql', 'https://youtu.be/7S_tz1z_5bA?si=upQQG_UYHTgfkEua'),
(38, 'Discrete Mathematics', 3, '2', '1', 'CpE 405', NULL, 'https://youtube.com/playlist?list=PLl-gb0E4MII28GykmtuBXNUNoej-vY5Rz&si=eYfk6B8uKJbUyxcn', 'https://www.coursera.org/learn/mathematical-thinking', 'https://www.coursera.org/learn/discrete-mathematics'),
(39, 'Individual and Dual Sports', 2, '2', '1', 'PE 103', NULL, 'https://youtube.com/playlist?list=PL5pSUbaFuoaNa3IBRfJt1adpUXzQQPWaV&si=Rl15_dZj9WZNydr5', '', ''),
(40, 'Object-Oriented Programming', 3, '2', '1', 'CS 211', NULL, 'https://www.coursera.org/learn/fundamentals-of-java-programming', 'https://www.coursera.org/projects/intermediate-oop-java', 'https://youtu.be/xk4_1vDrzzo?si=wIskuy4fmXbYwDh1'),
(41, 'Computer Programming', 3, '1', '2', 'CS 111', NULL, 'https://youtube.com/playlist?list=PLVnJhHoKgEmrAk6XdaioMlfmpD_ahnA-B&si=1JatLqSS-7rfUK5r', 'https://youtube.com/playlist?list=PLBlnK6fEyqRh6isJ01MBnbNpV3ZsktSyS&si=Pmbg-lZsD04R-s9W', 'https://youtube.com/playlist?list=PLvv0ScY6vfd8j-tlhYVPYgiIyXduu6m-L&si=yEU7GN444A6q3oTi'),
(42, 'Data Structures and Algorithms', 3, '1', '2', 'CS 131', NULL, 'https://youtu.be/Shl-MpNRhCY?si=4yLrTJsfNtkikbbR', 'https://www.coursera.org/learn/developer-data-structures-and-algorithms', ''),
(43, 'Filipino sa Ibat-ibang Disiplina', 3, '1', '2', 'Fili 102', NULL, 'https://youtube.com/playlist?list=PLYkVAo8Qc3gAWRRpcPVrgPexn683OIAPU&si=IzgqMV_r4echk6Kx', '', ''),
(44, 'Linear Algebra', 3, '1', '2', 'MATH 111', NULL, 'https://shorturl.at/sULqA', 'https://shorturl.at/8Hf8P', 'https://tinyurl.com/mtthu3zb'),
(45, 'NSTP - Civic Welfare Training Service 2', 3, '1', '2', 'NSTP 121CW', NULL, '', '', ''),
(46, 'Readings in Philippine History', 3, '1', '2', 'GEd 105', NULL, 'https://youtube.com/playlist?list=PLNAVpxVCuCD6uXaFVxfObzf2g7Q_cD0v5&si=hOvX635gouXuiWqR', '', ''),
(47, 'Rhythmic Activities', 2, '1', '2', 'PE 102', NULL, 'https://youtube.com/playlist?list=PL5pSUbaFuoaP4r-KSnXazL85Ulcaq3B6x&si=WPVWBhdW0gmnrWi8', '', ''),
(48, 'Science, Technology and Society', 3, '1', '2', 'GEd 109', NULL, 'https://youtube.com/playlist?list=PL9pvnJxOfTsXVZRdZn-YGGyiUFilLoNOE&si=ckh6cX-cePKSJz_K', '', ''),
(49, 'Art Appreciation', 3, '1', '1', 'GEd 108', NULL, '', '', ''),
(51, 'Kontekstwalisadong Komunikasyon sa Filipino', 3, '1', '1', 'Fili 101', NULL, 'https://lms.smu.edu.ph/course/info.php?id=450', '', ''),
(52, 'Life and Works of Rizal', 3, '1', '1', 'GEd 103', NULL, 'https://youtube.com/playlist?list=PLtcLUP3wjWR2nzmvsIJ_z68_p18mYyj6s&si=2wpHz511xuA8PZci', '', ''),
(53, 'Mathematics in the Modern World', 3, '1', '1', 'GEd 102', NULL, 'https://youtube.com/playlist?list=PLIVqM8B3LzJyG6kL6rU6GzfM3pu2HiZOS&si=AhH8tAk_vGsm2CvJ', 'https://youtube.com/playlist?list=PLHAaaIP6OJ3pptUFyogozgoCLahE7g2F7&si=msrwLJ4xqv-RS7UY', ''),
(54, 'NSTP - Civic Welfare Training Service 1', 3, '1', '1', 'NSTP 111CW', NULL, '', '', ''),
(55, 'Physical Fitness, Gymnastics and Aerobics', 2, '1', '1', 'PE 101', NULL, 'https://youtube.com/playlist?list=PLNAVpxVCuCD5r7qpwI9tx-F3nRlmxgSes&si=L-sHAxYKUK1dKQF2', '', ''),
(56, 'The Contemporary World', 3, '1', '1', 'GEd 104', NULL, 'https://youtube.com/playlist?list=PLsYlrWXG6nC9na5txxpfjNrQXOrunq2TB&si=0c2Ifqnv8Rz9D1D0 , https://youtu.be/z_yqK8KKwDc?si=kmLU6tS-WYW_X1P1', '', ''),
(57, 'Fundamentals of Business Analytics ', 3, '3', '1', 'BAT 401', 'Business Analytics', '', '', ''),
(58, 'Fundamentals of Analytics Modeling ', 3, '3', '1', 'BAT 402', 'Business Analytics', '', '', ''),
(59, 'Computer Networking 3', 3, '3', '1', 'NTT 401', 'Network Technology', '', '', ''),
(60, 'Internet of Things (IoT)', 3, '3', '1', 'NTT 402', 'Network Technology', '', '', ''),
(61, 'Fundamentals of Business Process Outsourcing 101 ', 3, '3', '1', 'SMT 401', 'Service Management', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `subject_status`
--

CREATE TABLE `subject_status` (
  `sub_stat_ID` int(11) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_status`
--

INSERT INTO `subject_status` (`sub_stat_ID`, `status`) VALUES
(1, 'ongoing'),
(2, 'completed'),
(3, 'Incomplete');

-- --------------------------------------------------------

--
-- Table structure for table `time`
--

CREATE TABLE `time` (
  `time_id` int(11) NOT NULL,
  `time` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time`
--

INSERT INTO `time` (`time_id`, `time`) VALUES
(1, '7:00 AM'),
(2, '8:00 AM'),
(3, '9:00 AM'),
(4, '10:00 AM'),
(5, '11:00 AM'),
(6, '12:00 PM'),
(7, '1:00 PM'),
(8, '2:00 PM'),
(9, '3:00 PM'),
(10, '4:00 PM'),
(11, '5:00 PM'),
(12, '6:00 PM'),
(13, '7:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `vcaacategories`
--

CREATE TABLE `vcaacategories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `linkOne` text NOT NULL,
  `linkTwo` text NOT NULL,
  `linkThree` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vcaacategories`
--

INSERT INTO `vcaacategories` (`id`, `categories`, `linkOne`, `linkTwo`, `linkThree`) VALUES
(1, 'COMMITMENT', 'https://www.zeneducate.com/resources/teacher-recruitment-and-retention-strategy-infographic', '', ''),
(2, 'KNOWLEDGE OF THE SUBJECT', '', '', ''),
(3, 'TEACHING FOR INDEPENDENT LEARNING', 'https://youtube.com/playlist?list=PLJ4onSZnMhY3l8I6A0PfDyBQ-Mmz90FAY&si=DZ1sKPyQrtPwBQoa', '', ''),
(4, 'MANAGEMENT OF LEARNING', 'https://youtu.be/blnvFbGTLoY?si=-g0hSvQniaeH74ft', '', ''),
(5, 'EMOTIONAL COMPETENCE', 'https://youtu.be/LXELNNliGAQ?si=ufaQrIR2X-MiwduW', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `vcaaexcel`
--

CREATE TABLE `vcaaexcel` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `cell_value` varchar(255) NOT NULL,
  `faculty_Id` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `academic_year` varchar(255) NOT NULL,
  `categoryOne` varchar(255) NOT NULL,
  `categoryTwo` varchar(255) NOT NULL,
  `categoryThree` varchar(255) NOT NULL,
  `categoryFour` varchar(255) NOT NULL,
  `categoryFive` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `year_level`
--

CREATE TABLE `year_level` (
  `year_id` int(11) NOT NULL,
  `year_level` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `year_level`
--

INSERT INTO `year_level` (`year_id`, `year_level`) VALUES
(1, 'FIRST'),
(2, 'SECOND'),
(3, 'THIRD'),
(4, 'FOURTH');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year_semester`
--
ALTER TABLE `academic_year_semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assigned_subject`
--
ALTER TABLE `assigned_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `average_ratings`
--
ALTER TABLE `average_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classroomcategories`
--
ALTER TABLE `classroomcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classroomcriteria`
--
ALTER TABLE `classroomcriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classroomdate`
--
ALTER TABLE `classroomdate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classdate` (`classdate`);

--
-- Indexes for table `classroomobservation`
--
ALTER TABLE `classroomobservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classroomquestions`
--
ALTER TABLE `classroomquestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complete_subject`
--
ALTER TABLE `complete_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`day_id`);

--
-- Indexes for table `enrolled_student`
--
ALTER TABLE `enrolled_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrolled_subject`
--
ALTER TABLE `enrolled_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facultycategories`
--
ALTER TABLE `facultycategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facultycriteria`
--
ALTER TABLE `facultycriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_averages`
--
ALTER TABLE `faculty_averages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_subject`
--
ALTER TABLE `failed_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`faculty_Id`);

--
-- Indexes for table `peertopeerform`
--
ALTER TABLE `peertopeerform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preferredschedule`
--
ALTER TABLE `preferredschedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prereq_subject`
--
ALTER TABLE `prereq_subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `randomfaculty`
--
ALTER TABLE `randomfaculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`sem_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentlogin`
--
ALTER TABLE `studentlogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentscategories`
--
ALTER TABLE `studentscategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentscriteria`
--
ALTER TABLE `studentscriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentsform`
--
ALTER TABLE `studentsform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_basic_info`
--
ALTER TABLE `student_basic_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_major`
--
ALTER TABLE `student_major`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_status`
--
ALTER TABLE `student_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `subject_status`
--
ALTER TABLE `subject_status`
  ADD PRIMARY KEY (`sub_stat_ID`);

--
-- Indexes for table `time`
--
ALTER TABLE `time`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `vcaacategories`
--
ALTER TABLE `vcaacategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vcaaexcel`
--
ALTER TABLE `vcaaexcel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year_level`
--
ALTER TABLE `year_level`
  ADD PRIMARY KEY (`year_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year_semester`
--
ALTER TABLE `academic_year_semester`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assigned_subject`
--
ALTER TABLE `assigned_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `average_ratings`
--
ALTER TABLE `average_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `classroomcategories`
--
ALTER TABLE `classroomcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `classroomcriteria`
--
ALTER TABLE `classroomcriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `classroomdate`
--
ALTER TABLE `classroomdate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `classroomobservation`
--
ALTER TABLE `classroomobservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `classroomquestions`
--
ALTER TABLE `classroomquestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `complete_subject`
--
ALTER TABLE `complete_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `day_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enrolled_student`
--
ALTER TABLE `enrolled_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `enrolled_subject`
--
ALTER TABLE `enrolled_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `faculty_averages`
--
ALTER TABLE `faculty_averages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `failed_subject`
--
ALTER TABLE `failed_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `faculty_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `peertopeerform`
--
ALTER TABLE `peertopeerform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `preferredschedule`
--
ALTER TABLE `preferredschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `prereq_subject`
--
ALTER TABLE `prereq_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `randomfaculty`
--
ALTER TABLE `randomfaculty`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=930;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `sem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studentlogin`
--
ALTER TABLE `studentlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `studentsform`
--
ALTER TABLE `studentsform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `student_basic_info`
--
ALTER TABLE `student_basic_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `student_major`
--
ALTER TABLE `student_major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `student_status`
--
ALTER TABLE `student_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `subject_status`
--
ALTER TABLE `subject_status`
  MODIFY `sub_stat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vcaacategories`
--
ALTER TABLE `vcaacategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vcaaexcel`
--
ALTER TABLE `vcaaexcel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `year_level`
--
ALTER TABLE `year_level`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
