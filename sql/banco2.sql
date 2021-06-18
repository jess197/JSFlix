DELETE FROM dados_pagamento;
DELETE FROM cadastro_usuario;

SELECT * 
  FROM cadastro_usuario c
     , dados_pagamento p 
 WHERE c.cpf = p.cpf;
 
 
 SELECT * 
   FROM filme f
	   , genero g  
  WHERE f.id_genero = g.id_genero; 
  
  
  SELECT * 
    FROM genero; 
    
    SELECT * 
      FROM recuperacao_senha;
      
      
UPDATE cadastro_usuario SET confirmacao = 0 ; 