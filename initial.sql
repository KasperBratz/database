set foreign_key_checks = 0;
drop table if exists Customers;
drop table if exists Orders;
drop table if exists Pallets;
drop table if exists Cookies;
drop table if exists Recipe;
drop table if exists RawMaterials;

set foreign_key_checks = 1;

create table Customers(
	name varChar(255) primary key,
	address varChar(255)
);

create table Orders(
	orderNbr int primary key,
	deliveryTime date,
	customerName varChar(255),
	delivered boolean,
	foreign key (customerName) references Customers(name)
);


create table RawMaterials(
	name varChar(255) primary key,
	amount int,
	lastDeliveryDate date,
	lastDeliveryAmount int
);

create table Cookies(
	cookieName varChar(255) primary key
);

create table Recipe(
	cookieName varChar(255),
	ingredient varChar(255),
	amount int,
	primary key (cookieName,ingredient),
	foreign key (cookieName) references Cookies(cookieName),
	foreign key (ingredient) references RawMaterials(name)

);

create table Pallets(
	palletNbr int primary key,
	timeMade date,
	orderNbr int,
	cookieName varChar(255),
	blocked boolean,
	sent boolean,
	foreign key (orderNbr) references Orders(orderNbr),
	foreign key (cookieName) references Cookies(cookieName)
);

insert into Customers values("Finkakor AB", "Helsingborg");
insert into Customers values("Småbröd AB", "Malmö");
insert into Customers values("Partybröd AB", "Månen");

insert into Cookies values("Amneris");
insert into Cookies values("Ballerina");
insert into Cookies values("Tango");


insert into RawMaterials values("Flour", 270000, '2016-03-03',10000);
insert into RawMaterials values("Suger", 20000, '2016-03-03', 600);
insert into RawMaterials values("Egg", 1000, '2016-03-03',500);

insert into Recipe values("Tango", "Flour", 270);
insert into Recipe values("Tango", "Suger", 200);
insert into Recipe values("Tango", "Egg", 10);

insert into Recipe values("Ballerina", "Flour", 200);
insert into Recipe values("Ballerina", "Suger", 170);
insert into Recipe values("Ballerina", "Egg", 8);

insert into Recipe values("Amneris", "Flour", 180);
insert into Recipe values("Amneris", "Suger", 100);
insert into Recipe values("Amneris", "Egg", 12);
