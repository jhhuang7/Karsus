/*
Queries for reference
*/

-- Items purchased by user
select * from Inventory p where p.name in 
	(select item from Purchase p inner join Inventory i on p.item = i.name where student = [id])
-- Items not yet purchased
select * from Inventory p where p.name not in 
	(select item from Purchase p inner join Inventory i on p.item = i.name where student = [id])

--purchase item
insert into Purchase values([id], [item_name])

--get balance (This is probably inefficient but I don't think it matters too much)
select  SUM(score)/COUNT(*) - SUM(cost)
as [Balance]
from Students
inner join Purchase on Students.id = Purchase.student
inner join Inventory on Purchase.item = Inventory.name
where Students.id = [id]
