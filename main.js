function displayWeek(evt, weekNum, league) {
    // Declare all variables
    var i, div, tablinks;

    // Get a value for weekNum based on active tab
    if (weekNum === null) {
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        if (tablinks[i].className.includes(" active")) {
          weekNum = tablinks[i].id;
        }
      }
    }

    // Get a value for league based on current selection in dropdown
    if (league === null) {
      dropdown = document.getElementById("league");
      league = dropdown.options[dropdown.selectedIndex].value;
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Populate the current table tab

    // TODO: add an element to control season switching
    var dataTable = document.getElementById("season 4 " + league + " data table");
    div = document.getElementById("TableContainer");
    div.innerHTML = '';
    var tbl = document.createElement("table");
    tbl.className = "match-table";
    var tblBody = document.createElement("tbody");
    for (i = 0; i < 10; i++) {
      var row = document.createElement("tr");
      for (var j = 0; j < 1; j++) {
        if (dataTable.rows.length > weekNum-1 && dataTable.rows[weekNum-1].cells.length > i) {
          var vals = dataTable.rows[weekNum-1].cells[i].innerHTML.split(",");
          var cell = document.createElement("td");
          var cellContents = document.createElement("div");
          cellContents.className = "match-container";

          var entry = document.createElement("div");
          entry.className = "match-entry";
          var button = document.createElement("button");
          button.className = "match-button";
          button.innerHTML = "View Details";
          button.addEventListener('click', createExtToggle(cellContents));
          var details = document.createElement("div");
          details.className = "match-details hidden";
          
          var tab = document.createElement("div");
          tab.className = "match-details-tab";

          var g1button = document.createElement("button");
          g1button.className = "tablinks-match active";
          g1button.addEventListener('click', createButtonFocus(details, tab, g1button));
          g1button.innerHTML = "Game 1";

          var g1contents = document.createElement("div");
          g1contents.className = "match-details-container active"
          var draftimage1 = document.createElement("img");
          draftimage1.className = "draft-image";
          // TODO: streamline decoding &amp;
          draftimage1.src = vals[5].replace("&amp;","&");
          var postgameimage1 = document.createElement("img");
          postgameimage1.className = "post-game-image";
          postgameimage1.src = vals[6];
          var matchlink1 = document.createElement("a");
          matchlink1.href = vals[7];
          matchlink1.innerHTML = "Match History";
          g1contents.appendChild(draftimage1);
          g1contents.appendChild(postgameimage1);
          g1contents.appendChild(matchlink1);


          var g2button = document.createElement("button");
          g2button.className = "tablinks-match";
          g2button.addEventListener('click', createButtonFocus(details, tab, g2button));
          g2button.innerHTML = "Game 2";


          var g2contents = document.createElement("div");
          g2contents.className = "match-details-container"
          var draftimage2 = document.createElement("img");
          draftimage2.className = "draft-image";
          // TODO: streamline decoding &amp;
          draftimage2.src = vals[8].replace("&amp;","&");
          var postgameimage2 = document.createElement("img");
          postgameimage2.className = "post-game-image";
          postgameimage2.src = vals[9];
          var matchlink2 = document.createElement("a");
          matchlink2.href = vals[10];
          matchlink2.innerHTML = "Match History";
          g2contents.appendChild(draftimage2);
          g2contents.appendChild(postgameimage2);
          g2contents.appendChild(matchlink2);

          tab.appendChild(g1button);
          tab.appendChild(g2button);
          details.appendChild(tab);
          details.appendChild(g1contents);
          details.appendChild(g2contents);
          
          // If a game 3 occurred
          if (vals[11] != "") {
            var g3button = document.createElement("button");
            g3button.className = "tablinks-match";
            g3button.addEventListener('click', createButtonFocus(details, tab, g3button));
            g3button.innerHTML = "Game 3";


            var g3contents = document.createElement("div");
            g3contents.className = "match-details-container"
            var draftimage3 = document.createElement("img");
            draftimage3.className = "draft-image";
            // TODO: streamline decoding &amp;
            draftimage3.src = vals[11].replace("&amp;","&");
            var postgameimage3 = document.createElement("img");
            postgameimage3.className = "post-game-image";
            postgameimage3.src = vals[12];
            var matchlink3 = document.createElement("a");
            matchlink3.href = vals[13];
            matchlink3.innerHTML = "Match History";
            g3contents.appendChild(draftimage3);
            g3contents.appendChild(postgameimage3);
            g3contents.appendChild(matchlink3);

            tab.appendChild(g3button);
            details.appendChild(g3contents);
          }


          const markup = `
          <div class='match-line'>
            <div class='match-participant'>
              <div class='participant-name'>${vals[1]}</div>
              <div class='participant-record-spoiler'>${vals[14]}-${vals[15]}</div>
            </div>
            <div class='match-participant'>vs</div>
            <div class='match-participant'>
              <div class='participant-name'>${vals[2]}</div>
              <div class='participant-record-spoiler'>${vals[16]}-${vals[17]}</div>
            </div>
          </div>
          <div class='match-spoiler'>
            <div class='match-winner-spoiler'>Winner: ${vals[3]}</div>
            <div class='match-score-spoiler'>${vals[4]}</div>
          </div>
          `;
          entry.innerHTML = markup;

          cellContents.appendChild(entry);
          cellContents.appendChild(button);
          cellContents.appendChild(details);

          cell.appendChild(cellContents);
          row.appendChild(cell);
        }
      }
      tblBody.appendChild(row);
    }
    tbl.appendChild(tblBody);
    div.appendChild(tbl)

    // Add an "active" class to the current week button
    document.getElementById(weekNum).className += " active";
    
}
function createExtToggle(container) {
  function toggleExtended(evt) {
    var button, details;
    for (var i = 0; i < container.children.length; i++) {
        if (container.children[i].className == "match-button") {
          button = container.children[i];
        } else if (container.children[i].className.includes("match-details")) {
          details = container.children[i];
        }
    }
    if (container.className.includes(" extended")){
      container.className = container.className.replace(" extended", "");
      button.innerHTML = "View Details";
      details.className += " hidden";
    } else{
      container.className += " extended";
      button.innerHTML = "Hide Details";
      details.className = details.className.replace(" hidden", "");
    }
  }
  return toggleExtended
}

function createButtonFocus(container, tab, button) {
  function takeFocus(evt) {
    for (var i = 0; i < tab.children.length; i++) {
      tab.children[i].className = tab.children[i].className.replace(" active", "");
    }
    // Start at child 1 because 0 is tab
    for (var i = 1; i < container.children.length; i++) {
      container.children[i].className = container.children[i].className.replace(" active", "");
    }
    container.children[parseInt(button.innerHTML.split(" ")[1])].className += " active";
    button.className += " active";
  }
  return takeFocus;
}
