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
	foreign key(customerName) references Customers(name)

);
create table RawMaterials(
	name varChar(255) primary key,
	amount int,
	lastDeliveryDate date,
	lastDeliveryAmount int
);

create table Cookies(
	cookieName varChar(255)
);

create table Recipe(
	cookieName varChar(255),
	ingredient varChar(255),
	amount int,
	primary key (cookieName,ingredient),
	foreign key cookieName references Cookies(cookieName),
	foreign key ingredient references RawMaterials(name)

);

create table Pallets(
	palletNbr int primary key,
	timeMade date,
	orderNbr int,
	cookieName varChar(255),
	blocked boolean,
	sent boolean,
	foreign key orderNbr references Orders(orderNbr),
	foreign key cookieName references Cookies(cookieName)
);
