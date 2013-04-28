CREATE TABLE IF NOT EXISTS `usercake_users_friends` (
  `Friend_Request_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Sender` int(11) NOT NULL,
  `Recipient` int(11) NOT NULL,
  PRIMARY KEY (`Friend_Request_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
