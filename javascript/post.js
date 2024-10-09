// รับค่า elements ที่เกี่ยวข้อง
const modal = document.getElementById('myModal_addpost');
const btnAdd = document.getElementById('add');
const spanClose = document.getElementsByClassName('close_addpost')[0];

// เมื่อกดปุ่ม Add ให้แสดง Modal
btnAdd.onclick = function() {
    modal.style.display = "flex"; // ใช้ flex เพื่อจัดกึ่งกลาง
}

// เมื่อกดปุ่ม Close (x) ให้ปิด Modal
spanClose.onclick = function() {
    modal.style.display = "none";
}

// เมื่อคลิกนอกหน้าต่าง Modal ให้ปิด Modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// ฟังก์ชันสำหรับยืนยันการทำงาน (Optional)
function confirmAction() {
    alert("ยืนยันแล้ว!");
    closePopup();
}

// ฟังก์ชันสำหรับปิด Modal (Optional)
function closePopup() {
    modal.style.display = "none";
}

