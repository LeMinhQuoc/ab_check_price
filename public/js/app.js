
function  checkAgain(){
    confirm("Are you sure to delete this product?");
  }
document.querySelectorAll('tr').forEach(row => {
  const td = Array.from(row.querySelectorAll('td[data-value]'));

  const values = td.map(cell => Number(cell.dataset.value));

  const min = Math.min(...values), max = Math.max(...values);

  td.forEach(cell => {
    const value = Number(cell.dataset.value);

    if (value === min) {
      cell.style.color = 'red';
      
    } else if (value === max) {
      cell.style.color = 'blue';
    }
  });
});
