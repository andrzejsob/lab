use lab;
SELECT o.id, o.nr, o.year, o.orderDate
FROM internal_order as o
JOIN contact_person AS cp ON cp.id = o.contactPersonId
JOIN client AS c ON c.id = cp.client_id
JOIN internal_order_method AS om ON om.internal_order_id = o.id
JOIN method AS m ON m.id = om.method_id
JOIN user_method AS um ON um.method_id = m.id
JOIN user AS u ON u.id = um.user_id
WHERE c.id = 1;
