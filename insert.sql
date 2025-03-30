INSERT INTO Laptops (id_pc, reference, name_pc, marque, cpu, gpu, ram, stockage, ecran, batterie, design, systeme_exploitation, poids, description, prix, quantite_stock, image_principale) 
VALUES 
(1, 'LPT-001', 'Dell XPS 15', 'Dell', 'Intel Core i7-12700H', 'NVIDIA RTX 3050 Ti', '16GB DDR5', '512GB SSD', '15.6" 4K OLED', '86Wh', 'Aluminium', 'Windows 11', '1.9kg', 
'Le Dell XPS 15 est un ordinateur portable haut de gamme conçu pour les professionnels et les créateurs de contenu à la recherche d\'une machine élégante et performante.  
Avec son écran OLED 4K de 15,6 pouces, il offre une qualité d\'affichage exceptionnelle, idéale pour la retouche photo et le montage vidéo. Son processeur Intel Core i7-12700H, couplé à 16 Go de RAM DDR5 et une carte graphique NVIDIA RTX 3050 Ti, garantit des performances fluides.  
Son design en aluminium brossé et sa légèreté (1.9 kg) en font un allié parfait pour les professionnels en déplacement. Avec une batterie de 86Wh et un SSD ultra-rapide, il offre une autonomie prolongée et des chargements rapides.', 
1899.99, 10, 'Dell_XPS_15.png'),

(2, 'LPT-002', 'MacBook Pro 16', 'Apple', 'Apple M2 Max', NULL, '32GB Unified', '1TB SSD', '16.2" Retina', '100Wh', 'Aluminium', 'macOS Ventura', '2.1kg', 
'Le MacBook Pro 16 pouces avec puce M2 Max est conçu pour les créateurs et les professionnels exigeants.  
Avec son écran Retina de 16,2 pouces, il offre une fidélité des couleurs exceptionnelle et une luminosité élevée, idéale pour l\'édition photo et vidéo. Sa puce M2 Max, couplée à 32 Go de mémoire unifiée et un SSD de 1 To, garantit des performances inégalées, même pour les tâches les plus gourmandes comme le rendu 3D ou la composition musicale.  
Grâce à sa batterie de 100Wh, il assure une autonomie impressionnante, tandis que son châssis en aluminium allie robustesse et élégance. Le clavier Magic Keyboard et les haut-parleurs haute fidélité améliorent encore l\'expérience utilisateur.', 
2999.99, 5, 'MacBook_Pro_16.png'),

(3, 'LPT-003', 'Asus ROG Strix G15', 'Asus', 'AMD Ryzen 9 6900HX', 'NVIDIA RTX 3070 Ti', '32GB DDR5', '1TB SSD', '15.6" 300Hz FHD', '90Wh', 'Plastique renforcé', 'Windows 11', '2.4kg', 
'L\'Asus ROG Strix G15 est une machine de gaming puissante, conçue pour offrir une fluidité exceptionnelle.  
Doté d\'un écran Full HD 300Hz, il garantit une réactivité extrême et une immersion totale. Son processeur AMD Ryzen 9 6900HX et sa carte graphique RTX 3070 Ti assurent des performances élevées pour les jeux les plus exigeants. Avec 32 Go de RAM DDR5 et un SSD de 1 To, il permet un multitâche fluide et des chargements ultra-rapides.', 
2199.99, 7, 'ASUS.png'),

(4, 'LPT-004', 'HP Spectre x360', 'HP', 'Intel Core i7-1255U', 'Intel Iris Xe', '16GB LPDDR4x', '512GB SSD', '13.5" OLED', '66Wh', 'Aluminium', 'Windows 11', '1.3kg', 
'Le HP Spectre x360 est un ultrabook convertible haut de gamme, parfait pour les professionnels et les étudiants.  
Son écran OLED de 13,5 pouces offre une qualité d\'affichage exceptionnelle et son format convertible permet une utilisation flexible en mode tablette ou ordinateur. Avec un châssis en aluminium, un processeur Intel Core i7 et une batterie longue durée, il allie puissance et portabilité.', 
1499.99, 12, 'HP_Spectre_x360.png'),

(5, 'LPT-005', 'Lenovo ThinkPad X1 Carbon', 'Lenovo', 'Intel Core i7-1280P', 'Intel Iris Xe', '16GB LPDDR5', '512GB SSD', '14" 2.2K IPS', '57Wh', 'Carbone et magnésium', 'Windows 11', '1.1kg', 
'Le Lenovo ThinkPad X1 Carbon est un ordinateur portable professionnel conçu pour allier performance et légèreté.  
Avec un poids de seulement 1,1 kg, un châssis en fibre de carbone et magnésium, et une autonomie longue durée, il est parfait pour les professionnels en déplacement. Son écran 2.2K IPS garantit un affichage précis, et son clavier rétroéclairé ThinkPad reste une référence en termes de confort de frappe.', 
1799.99, 8, 'Lenovo_ThinkPad_X1_Carbon.jpg');
-- table smartphones
INSERT INTO Smartphones (id_phone, reference, phone_name, marque, processeur, ecran, ram, stockage, appareil_photo, batterie, securite, design, dimensions, poids, description, prix, quantite_stock, image_principale) 
VALUES 
(1, 'PHN-001', 'iPhone 15 Pro Max', 'Apple', 'Apple A17 Pro', '6.7" Super Retina XDR OLED', '8GB', '256GB', '48MP + 12MP + 12MP', '4323mAh', 'Face ID', 'Titane', '159.9 x 76.7 x 8.3 mm', '221g', 
 'Le nouvel iPhone 15 Pro Max est conçu pour offrir des performances inégalées avec son puissant chipset A17 Pro. Son écran OLED de 6.7 pouces offre une qualité d\'affichage exceptionnelle. Doté d\'un système de caméra avancé, il permet de capturer des photos et vidéos dignes d\'un studio professionnel. Sa conception en titane le rend léger et durable.', 
 1499.99, 15, 'iphone15pro.png'),

(2, 'PHN-002', 'Samsung Galaxy S23 Ultra', 'Samsung', 'Snapdragon 8 Gen 2', '6.8" Dynamic AMOLED 2X', '12GB', '512GB', '200MP + 12MP + 10MP + 10MP', '5000mAh', 'Empreinte digitale (sous écran)', 'Aluminium et verre', '163.4 x 78.1 x 8.9 mm', '234g', 
 'Le Samsung Galaxy S23 Ultra est un smartphone haut de gamme doté d\'un écran AMOLED de 6.8 pouces avec un taux de rafraîchissement de 120Hz. Il est équipé d\'un capteur photo principal de 200MP permettant des clichés ultra détaillés. Sa batterie de 5000mAh assure une autonomie longue durée, et son stylet S Pen intégré améliore la productivité.', 
 1399.99, 10, 'samsung_s23_ultra.png'),

(3, 'PHN-003', 'Google Pixel 8 Pro', 'Google', 'Google Tensor G3', '6.7" LTPO OLED', '12GB', '256GB', '50MP + 48MP + 12MP', '5050mAh', 'Empreinte digitale & Face Unlock', 'Aluminium et verre', '162.6 x 76.5 x 8.7 mm', '213g', 
 'Le Google Pixel 8 Pro offre une expérience Android pure et optimisée, accompagnée d\'un appareil photo exceptionnel propulsé par l\'IA de Google. Son écran LTPO OLED 120Hz garantit une fluidité remarquable. Grâce à la puce Google Tensor G3, il excelle en photographie computationnelle et en performances globales.', 
 1199.99, 8, 'pixel_8_pro.png'),
(4, 'PHN-004', 'Sony Xperia 1 V', 'Sony', 'Snapdragon 8 Gen 2', '6.5" 4K OLED 120Hz', '12GB', '256GB', '48MP + 12MP + 12MP', '5000mAh', 'Empreinte digitale (latérale)', 'Verre Gorilla Glass Victus', '165 x 71 x 8.3 mm', '187g', 
 'Le Sony Xperia 1 V est conçu pour les passionnés de multimédia et de photographie. Son écran OLED 4K unique offre une précision d\'affichage exceptionnelle. Avec ses optiques Zeiss et son interface professionnelle inspirée des caméras Alpha, il permet de capturer des photos et vidéos d\'une qualité inégalée. Résistant à l\'eau et à la poussière (IP68), il est parfait pour une utilisation quotidienne.', 
 1299.99, 6, 'sony_xperia_1v.png'),

(5, 'PHN-005', 'Xiaomi 13 Pro', 'Xiaomi', 'Snapdragon 8 Gen 2', '6.73" AMOLED LTPO 120Hz', '12GB', '512GB', '50MP + 50MP + 50MP', '4820mAh', 'Empreinte digitale sous écran', 'Verre céramique', '162.9 x 74.6 x 8.4 mm', '210g', 
 'Le Xiaomi 13 Pro est un smartphone premium équipé d\'un capteur principal de 50MP avec une lentille Leica, offrant des clichés professionnels. Son écran AMOLED LTPO adaptatif assure une fluidité exemplaire. Grâce à sa charge rapide 120W, il se recharge en un temps record.', 
 1099.99, 9, 'xiaomi_13_pro.png');

-- table accessoires
INSERT INTO Accessoires (id_accessoire, reference, name, marque, type_accessoire, specifications, compatibilite, description, prix, quantite_stock, image_principale) 
VALUES 
(1, 'ACC-001', 'Clavier Mécanique RGB', 'Corsair', 'Clavier', 'Switches Cherry MX Red, RGB personnalisable, USB-C', 'Windows, macOS', 
'Un clavier mécanique haut de gamme avec un rétroéclairage RGB dynamique et des switches réactifs, idéal pour le gaming et la productivité.', 
129.99, 15, 'clavier_corsair.png'),

(2, 'ACC-002', 'Souris Gaming Logitech G502', 'Logitech', 'Souris', 'Capteur HERO 25K, 11 boutons programmables, RGB', 'Windows, macOS', 
'Une souris ergonomique et performante avec un capteur ultra-précis et des boutons programmables pour une expérience gaming optimale.', 
79.99, 20, 'souris_logitech_g502.png'),

(3, 'ACC-003', 'Casque Gamer HyperX Cloud II', 'HyperX', 'Casque', 'Son surround 7.1, micro amovible, USB et jack 3.5mm', 'PC, PS5, Xbox, Switch', 
'Un casque gaming confortable avec un son surround immersif et un micro de qualité pour les communications en jeu.', 
99.99, 12, 'casque_hyperx_cloud2.png'),

(4, 'ACC-004', 'Webcam Logitech C920', 'Logitech', 'Webcam', 'Résolution 1080p, Autofocus, Micro stéréo', 'Windows, macOS', 
'Une webcam Full HD idéale pour le streaming, les visioconférences et les appels vidéo professionnels.', 
89.99, 8, 'webcam_logitech_c920.png');

-- table stockage et composants
INSERT INTO Stockage_Composants (id_composant, reference, name, marque, type_composant, capacite, specifications, compatibilite, description, prix, quantite_stock, image_principale) 
VALUES 
(1, 'COMP-001', 'Seagate BarraCuda 2TB', 'Seagate', 'Disque Dur', '2TB', 'Cache 256MB, 3.5", 7200 RPM', 'Compatible PC et consoles', 
 'Le Seagate BarraCuda 2TB offre une grande capacité de stockage et des performances fiables pour les jeux, les vidéos et les fichiers volumineux.', 
 69.99, 20, 'seagate_barracuda_2tb.png'),

(2, 'COMP-002', 'Samsung 980 Pro 1TB', 'Samsung', 'SSD', '1TB', 'NVMe PCIe 4.0, V-NAND, 7000 MB/s', 'Compatible PC et PS5', 
 'Le SSD Samsung 980 Pro offre des vitesses fulgurantes grâce à son interface NVMe PCIe 4.0, parfait pour le gaming et la création de contenu.', 
 149.99, 15, 'samsung_980pro_1tb.png'),

(3, 'COMP-003', 'NVIDIA RTX 4070 Ti', 'NVIDIA', 'Carte Graphique', NULL, '12GB GDDR6X, Ray Tracing, DLSS 3.0, PCIe 4.0', 'Compatible avec cartes mères PCIe 4.0', 
 'La RTX 4070 Ti permet de jouer en 1440p et 4K avec une excellente fluidité et un support avancé du Ray Tracing.', 
 799.99, 10, 'rtx_4070_ti.png'),

(4, 'COMP-004', 'Intel Core i9-13900K', 'Intel', 'Processeur', NULL, '24 cœurs, 32 threads, 5.8 GHz, LGA 1700, 125W TDP', 'Compatible cartes mères LGA 1700', 
 'Un processeur ultra-performant conçu pour les jeux et les tâches intensives comme le montage vidéo ou la programmation.', 
 599.99, 12, 'intel_i9_13900k.png'),

(5, 'COMP-005', 'Corsair Vengeance RGB 32GB', 'Corsair', 'RAM', '32GB (2x16GB)', 'DDR5, 6000 MHz, Latence CL36, dissipateur thermique RGB', 'Compatible DDR5', 
 'Mémoire vive haute performance avec éclairage RGB personnalisable, idéale pour le gaming et la productivité.', 
 179.99, 25, 'corsair_vengeance_32gb.png'),

(6, 'COMP-006', 'ASUS ROG Strix Z790-E', 'ASUS', 'Carte Mère', NULL, 'Wi-Fi 6E, PCIe 5.0, USB 3.2 Gen2, ATX', 'Compatible Intel 12e et 13e Gen', 
 'Carte mère haut de gamme avec un excellent support des processeurs Intel récents et des dernières technologies.', 
 399.99, 8, 'asus_z790_e.jpg'),

(7, 'COMP-007', 'Corsair RM850x 80+ Gold', 'Corsair', 'Alimentation', '850W', 'Full modulaire, certification 80+ Gold, refroidissement silencieux', 'Compatible ATX/M-ATX', 
 'Alimentation modulaire avec une efficacité énergétique optimale et une fiabilité à toute épreuve.', 
 139.99, 18, 'corsair_rm850x.jpg'),

(8, 'COMP-008', 'NZXT H510 Elite', 'NZXT', 'Boîtier', NULL, 'Panneau en verre trempé, gestion des câbles optimisée, ventilation RGB incluse', 'Compatible ATX, M-ATX, ITX', 
 'Un boîtier premium avec une excellente circulation d’air et un design moderne avec éclairage RGB.', 
 159.99, 10, 'nzxt_h510_elite.png'),

(9, 'COMP-009', 'Noctua NH-D15', 'Noctua', 'Ventilateur', NULL, 'Double tour, 2 ventilateurs 140mm, 1500 RPM', 'Compatible Intel & AMD', 
 'Un des meilleurs ventirads du marché, assurant un refroidissement performant et silencieux.', 
 99.99, 14, 'noctua_nh_d15.png'),

(10, 'COMP-010', 'Corsair iCUE H150i Elite', 'Corsair', 'Watercooling', NULL, 'Radiateur 360mm, pompe silencieuse, éclairage RGB', 'Compatible Intel & AMD', 
 'Kit de watercooling haut de gamme offrant un excellent refroidissement et un design RGB attractif.', 
 189.99, 6, 'corsair_h150i.png');

