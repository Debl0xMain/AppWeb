$delivery[$x] = new Delivery();
                            
                            $delivery[$x]->setDelDateExped($date_client_expediction);
                            $delivery[$x]->setDelDatePlannedDelivery($date_client_livraison_estime);
                            $delivery[$x]->setDelDateDeliveryClient($date_client_livraison);
                            $delivery[$x]->setOrders($order[$x]);

                        $prix_client_ht_u = $productset[$productnombre]->getProPriceHT() * $userset[$usernombre]->getUserCompanyCoefficient();
                        
                        $productorder[$x] = new ProductOrders();
                        
                                $productorder[$x]->setProOrdProductQuantity($quantityboucle);
                                $productorder[$x]->setProOrdNameProduct($productset[$productnombre]->getProName()); 
                                $productorder[$x]->setProOrdPriceUht($prix_client_ht_u); 
                                $productorder[$x]->setProduct($productset[$productnombre]);
                                $productorder[$x]->setOrders($order[$x]);

                        $productdelivery[$x] = new ProductDelivery();
                        
                                $productdelivery[$x]->setProDelProductQuantity($quantityboucle); 
                                $productdelivery[$x]->setProduct($productset[$productnombre]);
                                $productdelivery[$x]->setDelivery($delivery[$x]);

                                $manager->persist($delivery[$x]);
                                $manager->persist($productorder[$x]);
                                $manager->persist($productdelivery[$x]);