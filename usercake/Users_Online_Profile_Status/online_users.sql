CREATE TABLE IF NOT EXISTS `userCake_Users_Online` (
  `Online_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Date_Time` int(11) NOT NULL,
  `User_IP` varchar(40) NOT NULL,
  `User_Session` int(1) NOT NULL,
  `Username` varchar(150) NOT NULL,
  PRIMARY KEY (`Online_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
