$(function () {
  previewAble();
});

const previewAble = () => {
  imgInput = document.querySelector("#photo");
  imgPreview = document.querySelector("#photo-preview");

  imgInput.onchange = (evt) => {
    const [file] = imgInput.files;
    if (file) {
      imgPreview.src = URL.createObjectURL(file);
    }
  };
};
