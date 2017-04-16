-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2017 at 09:25 PM
-- Server version: 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs405project`
--

-- --------------------------------------------------------

--
-- Table structure for table `crew`
--

CREATE TABLE `crew` (
  `cid` int(11) NOT NULL,
  `cname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crew`
--

INSERT INTO `crew` (`cid`, `cname`) VALUES
(1, 'Kevin Spacey'),
(2, 'Tom Hanks'),
(3, 'Brad Pitt'),
(4, 'Tom Cruise'),
(5, 'Jack Nickelson'),
(6, 'Ein Mcgergor'),
(7, 'Angelia Jolee'),
(8, 'Annette Bening'),
(9, 'Sam Mendes'),
(10, 'Alan Ball'),
(13, 'Name1'),
(14, 'Name2');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `gid` int(11) NOT NULL,
  `gname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`gid`, `gname`) VALUES
(1, 'Action'),
(2, 'Horror'),
(3, 'Drama'),
(4, 'Slasher'),
(5, 'Romance'),
(6, 'Thriller'),
(7, 'Think Piece'),
(8, 'SciFi'),
(9, 'Fantasy'),
(10, 'Comedy'),
(13, 'hello'),
(16, 'genre1'),
(17, 'genre2');

-- --------------------------------------------------------

--
-- Table structure for table `moviecrew`
--

CREATE TABLE `moviecrew` (
  `cid` int(11) NOT NULL,
  `mvid` int(11) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moviecrew`
--

INSERT INTO `moviecrew` (`cid`, `mvid`, `role`) VALUES
(1, 3, 'actor'),
(1, 10, 'voice'),
(3, 5, 'actor'),
(5, 2, 'actor'),
(5, 6, 'voice'),
(6, 6, 'voice'),
(8, 3, 'actor'),
(9, 3, 'writer'),
(10, 3, 'director'),
(10, 6, 'director'),
(13, 12, 'Role1'),
(14, 12, 'Role2');

-- --------------------------------------------------------

--
-- Table structure for table `moviegenre`
--

CREATE TABLE `moviegenre` (
  `gid` int(11) NOT NULL,
  `mvid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moviegenre`
--

INSERT INTO `moviegenre` (`gid`, `mvid`) VALUES
(10, 1),
(6, 2),
(3, 3),
(1, 4),
(1, 5),
(9, 6),
(1, 7),
(5, 8),
(9, 9),
(9, 10),
(16, 12),
(17, 12);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `mvid` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `summary` text,
  `releasedate` date DEFAULT NULL,
  `lang` varchar(100) DEFAULT NULL,
  `duration` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`mvid`, `title`, `summary`, `releasedate`, `lang`, `duration`) VALUES
(1, 'Mean Girls', 'Highschool girls', '2003-06-15', 'English', '01:25:53'),
(2, 'The Shining', 'Crazy guy in a hotel', '1976-09-09', 'English', '02:01:59'),
(3, 'American Beauty', 'Midlife Crisis', '2000-07-30', 'English', '01:45:02'),
(4, 'Rouge One', 'Another Star Wars Movie', '2016-12-11', 'English', '02:15:32'),
(5, 'Fight Club', 'Boxing underground', '1999-08-17', 'English', '01:28:39'),
(6, 'Golden Compas', 'Polar Bears', '2010-02-24', 'English', '02:56:13'),
(7, 'Sound of Music', 'Singing', '1954-01-01', 'English', '01:37:19'),
(8, 'Wizard of Oz', 'Tornado sweeps girl away', '1938-04-16', 'English', '01:43:11'),
(9, 'Gladiator', 'Roman war', '2000-09-17', 'English', '02:34:43'),
(10, 'The Hobbit', 'Short people', '2014-12-16', 'English', '02:15:14'),
(12, 'a', 'b', '2000-01-01', 'E', '03:00:00'),
(13, 'asdf', 'asdfaeee', '2000-04-05', 'S', '03:22:11'),
(14, 'bbbb', 'bbbb', '1900-01-01', 'bbb', '01:11:11'),
(15, 'f', 'f', '1901-01-01', 'f', '01:11:11');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `uid` int(11) NOT NULL,
  `mvid` int(11) NOT NULL,
  `rating` float DEFAULT NULL,
  `rcomment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`uid`, `mvid`, `rating`, `rcomment`) VALUES
(1, 2, 4.5, 'To violent'),
(2, 1, 3, 'Too childish'),
(2, 2, 9, 'Classic'),
(2, 3, 3, 'Life is short'),
(3, 2, 7, 'b'),
(5, 7, 10, 'Great Singing'),
(5, 8, 10, 'Great Singing'),
(6, 9, 7.3, 'Too Sad'),
(7, 4, 1, 'Everyone dies'),
(7, 10, 6, 'Not as good as LOTR'),
(10, 4, 8, 'Feel good action');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `mvid` int(11) NOT NULL,
  `tag` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`mvid`, `tag`) VALUES
(2, 'Insane'),
(3, 'Middle Class'),
(4, 'Fighting'),
(5, 'Fighting'),
(5, 'Insane'),
(6, 'Family Friendly'),
(7, 'Family Friendly'),
(9, 'Fighting'),
(10, 'Animals'),
(10, 'Hobbits');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `manager` tinyint(1) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `uname` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `DOB` date DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `manager`, `firstname`, `middlename`, `lastname`, `uname`, `password`, `DOB`, `gender`) VALUES
(1, 0, 'Isac', 'R', 'Sloan', 'bereal4', 'asdfjkl;', '2000-05-17', 'Male'),
(2, 1, 'Bobby', 'L', 'Smith', 'bsmitty', 'thisisbob', '1980-05-05', 'Male'),
(3, 0, 'Kelly', 'R', 'Jones', 'elpant', 'mensuck', '1987-07-09', 'Female'),
(4, 0, 'Cassandra', 'P', 'Gifford', 'fluffykitty', 'fluffmuffin', '2005-07-30', 'Female'),
(5, 1, 'Nancy', 'J', 'Cartman', 'mystic', 'giraffe', '1991-10-11', 'Female'),
(6, 0, 'Kyle', 'J', 'Brof', 'gingy', 'hanky', '1996-06-06', 'Male'),
(7, 0, 'Stan', 'M', 'Marsh', 'cammel', 'stanground', '1996-09-06', 'Male'),
(8, 1, 'Chelsea', 'R', 'Rockafeller', 'steely', 'queen', '1992-03-25', 'Female'),
(9, 0, 'Rick', 'B', 'Rivera', 'arod', 'baseball', '1970-11-01', 'Male'),
(10, 0, 'Billy', 'Q', 'Teddy', 'president', 'roosevelt', '2000-07-19', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `uid` int(11) NOT NULL,
  `mvid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`uid`, `mvid`) VALUES
(3, 1),
(3, 2),
(2, 3),
(3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crew`
--
ALTER TABLE `crew`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `moviecrew`
--
ALTER TABLE `moviecrew`
  ADD PRIMARY KEY (`cid`,`mvid`),
  ADD KEY `mvid` (`mvid`);

--
-- Indexes for table `moviegenre`
--
ALTER TABLE `moviegenre`
  ADD PRIMARY KEY (`gid`,`mvid`),
  ADD KEY `mvid` (`mvid`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`mvid`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`uid`,`mvid`),
  ADD KEY `mvid` (`mvid`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`mvid`,`tag`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`uid`,`mvid`),
  ADD KEY `mvid` (`mvid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crew`
--
ALTER TABLE `crew`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `mvid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `moviecrew`
--
ALTER TABLE `moviecrew`
  ADD CONSTRAINT `moviecrew_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `crew` (`cid`),
  ADD CONSTRAINT `moviecrew_ibfk_2` FOREIGN KEY (`mvid`) REFERENCES `movies` (`mvid`);

--
-- Constraints for table `moviegenre`
--
ALTER TABLE `moviegenre`
  ADD CONSTRAINT `moviegenre_ibfk_1` FOREIGN KEY (`gid`) REFERENCES `genre` (`gid`),
  ADD CONSTRAINT `moviegenre_ibfk_2` FOREIGN KEY (`mvid`) REFERENCES `movies` (`mvid`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`mvid`) REFERENCES `movies` (`mvid`);

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`mvid`) REFERENCES `movies` (`mvid`);

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`),
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`mvid`) REFERENCES `movies` (`mvid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
