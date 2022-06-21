<form action="{{ route('yyy') }}" method="get">
    <label for="cars">Choose a car:</label>
    <select name="cars" id="cars" multiple>
      <option value="volvo">Volvo</option>
      <option value="saab">Saab</option>
      <option value="opel">Opel</option>
      <option value="audi">Audi</option>
    </select>
    <input type="submit" value="Submit">

</form>

{{dd(@$xxx)}}
