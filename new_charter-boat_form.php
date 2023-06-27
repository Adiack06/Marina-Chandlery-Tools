<!DOCTYPE html>
<html>
<head>
  <title>Charter Boat Registration Form</title>
  <link rel="stylesheet" type="text/css" href="styles/form.css">
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="logo.png" alt="Logo">
    </div>
    <h1>Boat Registration Form</h1>
    <div class="explainer">
      <p>Fill out the form below to register your boat. Fields marked with * are required.</p>
    </div>
    <form action="inser_new_charter-boat.php" method="post">
      <div class="form-group">
        <label for="title">Title:*</label>
        <input type="text" id="title" name="title" maxlength="50" required>
      </div>
	  <div class="form-group">
        <label for="firstName">First Name:*</label>
        <input type="text" id="firstName" name="firstName" maxlength="25" required>
      </div>
      <div class="form-group">
        <label for="customerSurname">Surname:*</label>
        <input type="text" id="customerSurname" name="customerSurname" maxlength="50" required>
      </div>
	  <div class="form-group">
        <label for="email">Email:*</label>
        <input type="email" id="email" name="email" maxlength="50" required>
      </div>
	  <div class="form-group">
        <label for="chartercompany">Charter Company:*</label>
        <input type="text" id="chartercompany" name="chartercompany" maxlength="50" required>
      </div>
      <div class="form-group">
        <label for="boatName">Boat Name:*</label>
        <input type="text" id="boatName" name="boatName" maxlength="100" required>
      </div>
      <div class="form-group">
        <label for="type">Type:*</label>
        <select id="type" name="type" required>
          <option value="">No item selected</option>
          <?php
            $type = [
              "Sailing Yacht", "Motor Boat", "Rib", "Motor Sailer", "Catamaran", "Trimaran"
            ];

            sort($type); // Sort the type alphabetically

            foreach ($type as $type) {
              echo '<option value="' . $type . '">' . $type . '</option>';
            }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="make">Make:*</label>
        <input type="text" id="make" name="make" maxlength="50" required>
      </div>
      <div class="form-group">
        <label for="lengthFt">Length (ft):*</label>
        <input type="number" id="lengthFt" name="lengthFt" step="0.01" required oninput="convertLength('lengthFt', 'lengthMtrs', 0.3048)">
      </div>
      <div class="form-group">
        <label for="lengthMtrs">Length (mtrs):*</label>
        <input type="number" id="lengthMtrs" name="lengthMtrs" step="0.01" required oninput="convertLength('lengthMtrs', 'lengthFt', 3.28084)">
      </div>

      <script>
        function convertLength(inputId, targetId, conversionFactor) {
          const inputField = document.getElementById(inputId);
          const targetField = document.getElementById(targetId);

          // Get the value from the input field
          const inputValue = parseFloat(inputField.value);

          // Perform the conversion
          const convertedValue = inputValue * conversionFactor;

          // Update the target field with the converted value
          targetField.value = convertedValue.toFixed(2);
        }
      </script>

      <div class="form-group">
        <label for="notes">Notes:</label>
        <textarea id="notes" name="notes" maxlength="255"></textarea>
      </div>
      <div class="form-group">
        <label for="homePort">Home Port:*</label>
        <input type="text" id="homePort" name="homePort" maxlength="50" required>
      </div>
      <div class="form-group">
        <label for="homeCountry">Home Country:*</label>
        <select id="homeCountry" name="homeCountry" required>
		<option value="">No item selected</option>
          <?php
            $countries = [
				"Scotland", "England", "Wales", "Northern Ireland", "Ireland",
				"Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas",
				"Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei",
				"Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros",
				"Congo (Congo-Brazzaville)", "Costa Rica", "Côte d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czechia (Czech Republic)", "Democratic Republic of the Congo", "Denmark",
				"Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini (fmr. 'Swaziland')",
				"Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana",
				"Haiti", "Holy See", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan",
				"Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania",
				"Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova",
				"Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique", "Myanmar (formerly Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua",
				"Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine State", "Panama", "Papua New Guinea",
				"Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines",
				"Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia",
				"Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan",
				"Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates",
				"United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
			];

            

            foreach ($countries as $country) {
              echo '<option value="' . $country . '">' . $country . '</option>';
            }
          ?>
        </select>
      </div>
	  <div class="form-group">
		<label for="mailingList">Mailing List:</label>
		<input type="checkbox" id="mailingList" name="mailingList" value="1" min="0" max="1">
	  </div>
      <div class="submit-button">
        <input type="submit" value="Submit">
      </div>
    </form>
  </div>
  <script>
    function validateForm() {
      var typeSelect = document.getElementById("type");
      var countrySelect = document.getElementById("homeCountry");

      // Check if either or both selectors are not selected
      if (typeSelect.value === "" || countrySelect.value === "") {
        alert("Please select a value for Type and Home Country.");
        return false; // Prevent form submission
      }

      return true; // Allow form submission
    }
  </script>
</body>
</html>
