-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 01, 2013 at 02:07 AM
-- Server version: 5.5.8
-- PHP Version: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: 'fluency_test'
--

-- --------------------------------------------------------

--
-- Table structure for table 'ethernet_quotes'
--

DROP TABLE IF EXISTS ethernet_quotes;
CREATE TABLE IF NOT EXISTS ethernet_quotes (
  id int(11) NOT NULL AUTO_INCREMENT,
  person_id int(11) NOT NULL,
  customer_name varchar(300) NOT NULL,
  date_created datetime NOT NULL,
  contract_length int(5) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'ethernet_quote_items'
--

DROP TABLE IF EXISTS ethernet_quote_items;
CREATE TABLE IF NOT EXISTS ethernet_quote_items (
  id int(11) NOT NULL AUTO_INCREMENT,
  ethernet_quote_id int(11) NOT NULL,
  site_name varchar(500) NOT NULL,
  postcode varchar(20) NOT NULL,
  bandwidth int(11) NOT NULL,
  bearer int(11) NOT NULL,
  carrier varchar(500) NOT NULL,
  buy_price_install float NOT NULL,
  buy_price_rental float NOT NULL,
  wholesale_price_install float NOT NULL,
  wholesale_price_rental float NOT NULL,
  rrp_price_install float NOT NULL,
  rrp_price_rental float NOT NULL,
  PRIMARY KEY (id),
  KEY ethernet_quote_id (ethernet_quote_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ethernet_quote_items`
--
ALTER TABLE `ethernet_quote_items`
  ADD CONSTRAINT ethernet_quote_items_ibfk_1 FOREIGN KEY (ethernet_quote_id) REFERENCES ethernet_quotes (id);
