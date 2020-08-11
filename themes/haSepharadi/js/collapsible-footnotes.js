// Collapsible Footnotes

var footnotesWrapper = document.getElementsByClassName("easy-footnotes-wrapper")[0];
// console.log(footnotesWrapper);
// footnotesWrapper.style.display = "none";

// footnotesWrapper.style.display = "none";

// Create a new element
var angleIcon = document.createElement('i');
angleIcon.setAttribute("class", "far fa-angle-right footnotes-arrow");

// Get the reference node
var footnotesTitleElem = document.querySelector('.easy-footnote-title');

// Insert the new node before the reference node
// footnotesTitleElem.after(angleIcon); 
footnotesTitleElem.appendChild(angleIcon);


var coll = document.getElementsByClassName("easy-footnote-title");
var i;
console.log(coll);

// coll[0].setAttribute("style", "color: blue;");
for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = document.getElementsByClassName("easy-footnotes-wrapper")[0];
    var arrowRight = document.getElementsByClassName("fa-angle-right")[0];
//     console.log("content", content);
//     console.log("arrow", arrowRight);
    content.style.display = "none;";
    // content.style.border = "1px solid red";

    if (content.style.display === "block") {
      content.style.display = "none";
      content.style.overflow = "hidden";
      arrowRight.classList.remove("fa-rotate-90");
//       console.log(arrowRight);
    } else {
      content.style.display = "block";
      content.style.overflow = "visible";
//       arrowRight.setAttribute("class", "far fa-angle-right fa-rotate-90");
      arrowRight.classList.add("fa-rotate-90");
    }
  });
}
