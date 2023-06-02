CREATE DATABASE u871226378_Colabora;

USE u871226378_Colabora;

CREATE TABLE Users (
    User_Id       INT AUTO_INCREMENT,
    User_Name     VARCHAR(80) NOT NULL,
    User_Email    VARCHAR(80) NOT NULL,
    User_Password VARCHAR(200) NOT NULL,
    User_Number   VARCHAR (11) NOT NULL,
    User_Gender   VARCHAR (12) NOT NULL, 
    User_Type     VARCHAR (9) NOT NULL,
    PRIMARY KEY(User_Id)
);

CREATE TABLE Products (
    Product_Id          INT AUTO_INCREMENT,
    Product_Name        VARCHAR(80) NOT NULL,
    Product_Description VARCHAR(300) DEFAULT NULL,
    Product_Price       DECIMAL(10, 2) NOT NULL,
    Product_Date        DATETIME NOT NULL,
    User_Id             INT,
    PRIMARY KEY(Product_Id),
    FOREIGN KEY(User_Id) REFERENCES Users(User_Id)
);

CREATE TABLE Images (
    Image_Id   INT AUTO_INCREMENT,
    Image_Name VARCHAR(50) NOT NULL,
    Image_Date DATETIME NOT NULL,
    User_Id    INT,
    Product_Id INT,
    PRIMARY KEY (Image_Id),
    FOREIGN KEY(User_Id) REFERENCES Users(User_Id),
    FOREIGN KEY(Product_Id) REFERENCES Products(Product_Id)
);

CREATE TABLE Messages (
    Message_Id INT AUTO_INCREMENT,
    Message_Sender VARCHAR(80) NOT NULL,
    Message_Receiver VARCHAR(80) NOT NULL,
    Message_Content VARCHAR(300) NOT NULL,
    Message_Product INT NOT NULL,
    Message_Date DATETIME NOT NULL,
    Message_Readed BOOLEAN NOT NULL,
    PRIMARY KEY(Message_Id)
);
