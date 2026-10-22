/* ==========================================================================
   DASHBOARD.JS - pop-up modals on the pages in pages/after/
   Used by: <button onclick="openModal('id')"> / closeModal('id')
   Styles: main.css (section 10)
   ========================================================================== */
function openModal(id) {
    document.getElementById(id).style.display = 'block';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
