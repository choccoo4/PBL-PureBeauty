function toggleMenu() {
    const sideMenu = document.getElementById('side-menu');
    if (sideMenu.style.width === '0px' || sideMenu.style.width === '') {
      sideMenu.style.width = '250px';
    } else {
      sideMenu.style.width = '0';
    }
  }
  