function logout(token)
{
  window.location = "https://www.facebook.com/logout.php?next=http://localhost/sf/main.php&access_token=" + token; 
}
