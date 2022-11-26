-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2022 at 10:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evoting`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `admin_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(68) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`admin_id`, `fname`, `mname`, `lname`, `username`, `password`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

-- --------------------------------------------------------

--
-- Table structure for table `tblcandidate`
--

CREATE TABLE `tblcandidate` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `partyid` int(11) NOT NULL,
  `candidatepositionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcandidate`
--

INSERT INTO `tblcandidate` (`id`, `studentid`, `partyid`, `candidatepositionid`) VALUES
(94, 131, 22, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tblcandidateposition`
--

CREATE TABLE `tblcandidateposition` (
  `id` int(11) NOT NULL,
  `positionname` varchar(30) NOT NULL,
  `sortorder` int(5) NOT NULL,
  `votesallowed` int(5) NOT NULL,
  `allowperparty` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcandidateposition`
--

INSERT INTO `tblcandidateposition` (`id`, `positionname`, `sortorder`, `votesallowed`, `allowperparty`) VALUES
(5, 'President', 1, 50, 50);

-- --------------------------------------------------------

--
-- Table structure for table `tblcourse`
--

CREATE TABLE `tblcourse` (
  `id` int(11) NOT NULL,
  `courseinitial` varchar(8) DEFAULT NULL,
  `coursename` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcourse`
--

INSERT INTO `tblcourse` (`id`, `courseinitial`, `coursename`) VALUES
(18, 'Mahogany', 'sdasda a'),
(19, 'Gumamela', 'dsad ad a'),
(20, 'Acacia', 'asasd sd');

-- --------------------------------------------------------

--
-- Table structure for table `tblparty`
--

CREATE TABLE `tblparty` (
  `id` int(11) NOT NULL,
  `partyinitial` varchar(11) NOT NULL,
  `partyname` varchar(100) NOT NULL,
  `party_election_date_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblparty`
--

INSERT INTO `tblparty` (`id`, `partyinitial`, `partyname`, `party_election_date_id`) VALUES
(9, 'likes', 'likes', 1),
(10, 'secret', 'secret', 1),
(11, 'bon', 'bon', 2),
(12, '23213', 'adasd', 10),
(13, 'zxc', 'zxc', 10),
(14, 'xxx', 'xxx', 10),
(15, 'yyy', 'yyy', 10),
(16, 'Fresh', 'Team Fresh', 23),
(17, 'bon', 'BON BON', 23),
(18, 'qqq', 'qqq', 30),
(19, 'bon', 'BonBon', 30),
(20, 'Party 2', 'Party List 2', 33),
(21, 'Party1', 'Party List 1', 33),
(22, 'sdasd', 'asdadsa', 34);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `id` int(11) NOT NULL,
  `idno` varchar(15) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `middlename` varchar(30) NOT NULL,
  `courseid` int(5) DEFAULT NULL,
  `image` varchar(30) NOT NULL,
  `votingcode` varchar(15) DEFAULT NULL,
  `votestatus` char(1) DEFAULT NULL COMMENT '0 - not voted, 1 - voted',
  `yearlevelid` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`id`, `idno`, `lastname`, `firstname`, `middlename`, `courseid`, `image`, `votingcode`, `votestatus`, `yearlevelid`) VALUES
(128, '2345-2345', 'Peter', 'John', 'M', NULL, 'Doctor-Consultation.png', 'CHM-760861', '0', NULL),
(129, '2345-23', 'Curry', 'Stephen', 'H', NULL, '8196186971_2237f161bd_b.jpg', 'EDJ-806834', '0', NULL),
(130, '235-1235', 'Meyer', 'Jane', 'F', NULL, '', 'TSA-B08A66', '0', NULL),
(131, '2345-23', 'Escobar', 'Mars', 'T', NULL, '', 'ANO-68C479', '0', NULL),
(133, '235-23', 'James', 'Kate', 'M', NULL, '', 'KNG-018585', '0', NULL),
(134, '5423-23', 'Miranda', 'Ching', 'P', NULL, 'images (16).jpg', 'HAU-5663B5', '0', NULL),
(135, '123-456', 'Doe', 'John', 'x', NULL, '', 'YNP-C61090', '0', NULL),
(136, 'dasd', 'dasd', 'dasd', 'adas', 19, '', 'AFP-B1F58A', '0', 19),
(137, 'sdasd', 'asd', 'asda', 'dasd', 19, '', 'KMX-9860C3', '0', 19),
(138, '23ad', ' adasd', 'sda', 'dasd', 19, '', 'KJL-D15656', '0', 19),
(139, 'sdasd', 'dasd', 'dasd', 'da', 20, '', 'PJM-F1354A', '1', 18),
(140, 'dasd', 'dasd', 'dasd', 'das', 18, '', 'MWB-8E391C', '0', 19);

-- --------------------------------------------------------

--
-- Table structure for table `tblvotes`
--

CREATE TABLE `tblvotes` (
  `id` int(11) NOT NULL,
  `candidateid` int(11) NOT NULL,
  `daterecorded` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblvotes`
--

INSERT INTO `tblvotes` (`id`, `candidateid`, `daterecorded`) VALUES
(90, 94, '2022-11-17 07:04:41'),
(91, 94, '2022-11-17 07:07:27'),
(92, 94, '2022-11-17 07:08:42'),
(93, 94, '2022-11-17 07:13:23'),
(94, 94, '2022-11-17 07:14:41'),
(95, 94, '2022-11-17 07:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `tblvotestatus`
--

CREATE TABLE `tblvotestatus` (
  `vote_status_id` int(11) NOT NULL,
  `vote_status_election_date_id` int(11) NOT NULL,
  `vote_status_studentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblvotestatus`
--

INSERT INTO `tblvotestatus` (`vote_status_id`, `vote_status_election_date_id`, `vote_status_studentid`) VALUES
(34, 34, 136),
(35, 34, 137),
(36, 34, 138),
(37, 34, 139),
(38, 34, 140);

-- --------------------------------------------------------

--
-- Table structure for table `tblyearlevel`
--

CREATE TABLE `tblyearlevel` (
  `id` int(12) NOT NULL,
  `yearlevelinitial` varchar(10) NOT NULL,
  `yearlevelname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblyearlevel`
--

INSERT INTO `tblyearlevel` (`id`, `yearlevelinitial`, `yearlevelname`) VALUES
(18, 'G4', 'Grade 4'),
(19, 'G5', 'Grade 5'),
(20, 'G6', 'Grade 6');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_election_date`
--

CREATE TABLE `tbl_election_date` (
  `election_date_id` int(11) NOT NULL,
  `election_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_election_date`
--

INSERT INTO `tbl_election_date` (`election_date_id`, `election_date`) VALUES
(34, '2022-11-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partyid` (`partyid`),
  ADD KEY `candidatepositionid` (`candidatepositionid`),
  ADD KEY `candidatepositionid_2` (`candidatepositionid`),
  ADD KEY `studentid` (`studentid`);

--
-- Indexes for table `tblcandidateposition`
--
ALTER TABLE `tblcandidateposition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcourse`
--
ALTER TABLE `tblcourse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblparty`
--
ALTER TABLE `tblparty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `votingcode` (`votingcode`),
  ADD KEY `courseid` (`courseid`),
  ADD KEY `yearlevelid` (`yearlevelid`);

--
-- Indexes for table `tblvotes`
--
ALTER TABLE `tblvotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidateid` (`candidateid`);

--
-- Indexes for table `tblvotestatus`
--
ALTER TABLE `tblvotestatus`
  ADD PRIMARY KEY (`vote_status_id`),
  ADD KEY `vote_status_election_date_id` (`vote_status_election_date_id`,`vote_status_studentid`),
  ADD KEY `vote_status_studentid` (`vote_status_studentid`);

--
-- Indexes for table `tblyearlevel`
--
ALTER TABLE `tblyearlevel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_election_date`
--
ALTER TABLE `tbl_election_date`
  ADD PRIMARY KEY (`election_date_id`),
  ADD UNIQUE KEY `election_date` (`election_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tblcandidateposition`
--
ALTER TABLE `tblcandidateposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblcourse`
--
ALTER TABLE `tblcourse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblparty`
--
ALTER TABLE `tblparty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tblvotes`
--
ALTER TABLE `tblvotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tblvotestatus`
--
ALTER TABLE `tblvotestatus`
  MODIFY `vote_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tblyearlevel`
--
ALTER TABLE `tblyearlevel`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_election_date`
--
ALTER TABLE `tbl_election_date`
  MODIFY `election_date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  ADD CONSTRAINT `tblcandidate_ibfk_2` FOREIGN KEY (`partyid`) REFERENCES `tblparty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblcandidate_ibfk_3` FOREIGN KEY (`candidatepositionid`) REFERENCES `tblcandidateposition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblcandidate_ibfk_4` FOREIGN KEY (`studentid`) REFERENCES `tblstudent` (`id`);

--
-- Constraints for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD CONSTRAINT `tblstudent_ibfk_1` FOREIGN KEY (`courseid`) REFERENCES `tblcourse` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tblstudent_ibfk_2` FOREIGN KEY (`yearlevelid`) REFERENCES `tblyearlevel` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblvotes`
--
ALTER TABLE `tblvotes`
  ADD CONSTRAINT `tblvotes_ibfk_1` FOREIGN KEY (`candidateid`) REFERENCES `tblcandidate` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblvotestatus`
--
ALTER TABLE `tblvotestatus`
  ADD CONSTRAINT `tblvotestatus_ibfk_1` FOREIGN KEY (`vote_status_election_date_id`) REFERENCES `tbl_election_date` (`election_date_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblvotestatus_ibfk_2` FOREIGN KEY (`vote_status_studentid`) REFERENCES `tblstudent` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
