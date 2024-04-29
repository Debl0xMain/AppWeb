import React, { useEffect, useState } from 'react';
import { Collapse } from 'react-bootstrap';

const Api = () => {
  const [tableau, setTableau] = useState([]);
  const [openIndex, setOpenIndex] = useState(null);
  const [price_user,setPrice_user] = useState(1.80)

  useEffect(() => {
    const url_user = '/api_new/user_coef'

    fetch(url_user)
    .then((resp) => resp.json())
    .then(function(data) {
      setPrice_user(data)
    });

  }, []);

  useEffect(() => {
    const url = '/api/categories';
      
    fetch(url)
      .then((resp) => resp.json())
      .then(function(data) {
        var href = window.location.href
        var par  = href.split('/');
        let param_cat = par[4]
        var tableau = data
        var categorie_found = null;

        for (var i = 0; i < tableau.length; i++) {
          if (tableau[i].catName.toUpperCase() === param_cat.toUpperCase()) {
            categorie_found = tableau[i];
            break;
          }
        }
        var categorie_filter = categorie_found['subcategory']
        var produits = []
        for (var x = 0; x < categorie_filter.length; x++) {
          for(var y = 0; y < categorie_filter[x]['products'].length; y++){
            produits.push(categorie_filter[x]['products'][y]);
          }
        }

        setTableau(produits);
      });
  }, []);

  const toggleCollapse = (index) => {
    setOpenIndex(openIndex === index ? null : index);
  };

  const add_bask = (id) => {
    fetch("/bask/add", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ id_produit: id })
    })
    .then((response) => response.json())
    .then((data) => {
      console.log('success');
      chargerPanier();
    })
    .catch((error) => console.log(error));
  }
  
  return (
    <>
      <article className='d-flex align-item-center justify-content-center'>
        <div className='row mx-5 my-1 text-center'>
          {tableau.map((item, index) => (
            item.proActive === 1 ? (
              <div key={index} className='col-lg-4 my-2'>
                <div className='border mx-3 rounded-bottom mx-auto w-100 btn'>
                  <p>{item.proName}</p>
                  <img src={`/assets/product/${item.proPictureName}`} alt={item.proName} height={'100px'} width={'100px'} />
                  <div className='d-flex justify-content-end'>
                    <p className='text-end font-weight-bold'>{(parseFloat(item.proPriceHT) * price_user).toFixed(2) + ' €'}</p>
                  </div>
                  <div className='d-flex justify-content-end mx-2'>
                  <button className='btn btn-outline-success' id={"btn_"+item.id} onClick={() => add_bask(item.id)}>
                      <i className="fa-solid fa-cart-plus"></i>
                  </button>
                  </div>
                  <button className='btn' onClick={() => toggleCollapse(index)}><i className="fa-solid fa-chevron-down"></i></button>
                  <Collapse in={openIndex === index}>
                    <div>
                    <p className='text-end font-weight-bold'>{(parseFloat(item.proPriceHT) * price_user).toFixed(2) + ' €'} </p>
                    <p className='text-end'>Tva : 20%</p>
                      <p className='border rounded py-1 px-1'>{item.proDesc}</p>
                    </div>
                  </Collapse>
                </div>
              </div>
            ) : null
          ))}
        </div>
      </article>
    </>
  );
}

export default Api;
