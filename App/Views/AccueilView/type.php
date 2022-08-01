<div class="container">
<div class="row">
<div class="col-md-5">
<var id="result-container" class="result-container"></var>
 
<form >
  <div class="typeahead__container">
    <div class="typeahead__field">
      <div class="typeahead__query">
        <input id="txtMat" class="form-control" placeholder="Rechercher" autocomplete="off">
      </div>
      <div class="typeahead__button">
        <button type="submit">
          <i class="typeahead__search-icon"></i>
        </button>
      </div>
    </div>
  </div>
</form>
</div>
</div>
</div>
<script>
$.typeahead({
    input:'#txtMat',
    minLength:3,
    maxItem:20,
    order:'asc',
    display:['value'],
    template:'{{value}}',
    hint:true,
    searchOnFocus: true,
    blurOnTab: false,
    emptyTemplate: 'Aucun résultat trouvé : {{query}}',
    
    source: {
       matiere:{
           ajax:{
               type:'POST',
               url:'/Accueil/getNews',
           }
       }
    },
    debug: true,
    callback: {
        onClick: function (node,a,b) {
            console.log(b.id);
            
        }
    }
});
</script>