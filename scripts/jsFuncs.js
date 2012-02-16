function logout(token)
{
  window.location = "https://www.facebook.com/logout.php?next=http://localhost/sf/main.php&access_token=" + token;
}

function populateCourses(crs)
{
  var list = document.getElementById('crsMenu');
  var ul = document.createElement('ul');
  var li, a, txt, url;
  for(var i = 0; i < crs.length; i++)
  {
    li = document.createElement('li');
    a = document.createElement('a');
    url = 'courses.php?c='+crs[i].name;
    a.setAttribute('href', url);
    txt = document.createTextNode(crs[i].name);
    a.appendChild(txt);
    li.appendChild(a);
    ul.appendChild(li);
  }
  list.appendChild(ul);
}
