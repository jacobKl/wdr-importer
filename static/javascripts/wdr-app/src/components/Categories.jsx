import React from 'react'

function Categories({categories, handleCategoryChange}) {
  return (
    <div className="step" data-aos="fade-right">
        <h3>Wybierz kategorie naprawy</h3>
        <div className="categories">
            {categories.map((category) => (
                <div key={category.id} onClick={() => handleCategoryChange(category)} className="category">
                    <img src={category.image}/>
                    <h3>{category.name}</h3>
                </div>
            ))}
        </div>
    </div>
  )
}

export default Categories