-- update cost.json and finance.json
-- build assets

INSERT INTO `regions` (`name`, `type_id`, `parent_id`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES ('Jamniwala', '408', '315', now(), NULL, NULL, '0', NULL, NULL);

UPDATE `activities` SET `type_id` = '201' WHERE `id` = '91';
UPDATE `activities` SET `name` = 'Teleprinter/fax services' WHERE `id` = '68';
UPDATE `activities` SET `name` = 'Petrol Pump' WHERE `id` = '96';

INSERT INTO `activities` (`name`, `type_id`, `requires_address`, `has_land_component`, `has_building_component`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`)
VALUES ('Other manufacturing n.e.c.', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacturing of food products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacturing of computers and peripheral equipment', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacturing of other electrical equipment', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of dairy products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of other fabricated metal products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Metal work service activities', '202', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of furniture', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of other textiles', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of products of wood, cork, straw and plaiting materials', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of beverages', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of basic iron and steel', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of paper and paper products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of communication equipment', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of pharmaceuticals, medicinal chemical and botanical products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of bodies (coachwork) for motor vehicles', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of trailers and semi-trailers', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of prepared animal feeds', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of plastics products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of basic metals', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of transport equipment n.e.c.', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of wearing apparel, except fur apparel', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Installation of industrial machinery and equipment', '202', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of grain mill products, starches and starch products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of footwear', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of articles of fur', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of wiring and wiring devices', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of knitted and crocheted apparel', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of electric lighting equipment', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Printing and reproduction of recorded media', '202', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of vegetable and animal oils and fats', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of parts and accessories for motor vehicles', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of air and spacecraft and related machinery', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Processing and preserving of meat and fish', '202', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of jewellery, bijouterie and related articles', '202', '1', '1', '1', now(), NULL, NULL, '1', NULL, NULL),
('Manufacture of rubber and plastics products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of glass and glass products', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Sawmilling and planing of wood', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Spinning, weaving and finishing of textiles', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of railway locomotives and rolling stock', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of man-made fibres', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of games and toys', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of medical and dental instruments and supplies', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of electronic components', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of structural metal products, tanks, reservoirs and steam generators', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of domestic appliances', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of sports goods', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Repair of fabricated metal products, machinery and equipment', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of motor vehicles', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of electric motors, generators, transformers and electricity distribution and control apparatus', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of consumer electronics', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Processing and preserving of fruit and vegetables', '202', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of machinery and equipment n.e.c.', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL),
('Manufacture of measuring, testing, navigating and control equipment', '201', '1', '1', '1', now(), NULL, NULL, '0', NULL, NULL);

