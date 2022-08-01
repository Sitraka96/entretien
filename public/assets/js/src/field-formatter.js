class FieldFormatter {
  constructor(selector) {
    this.selector = selector || "[data-format-field]";
    this.formatType = null;
    this.allowedPhoneNumbers = ["020", "032", "034", "038"];
    this.element().addEventListener("keypress", (event) => {
      if (isNaN(event.key) && event.key != "+") {
        event.preventDefault();
      } else {
        this.format(event);
      }
    });
    this.element().addEventListener("change", (event) => {
      this.format(event);
    });
    this.format({ key: null, preventDefault: () => {} });
  }

  element() {
    return this.selector == "[data-format-field]"
      ? document.querySelector(this.selector)
      : this.selector;
  }

  value(value) {
    if (value) {
      this.element().value = value;
    }
    return this.element().value;
  }

  valueLength() {
    const value = this.element().value.replaceAll(" ", "");
    return value.length;
  }

  type() {
    return this.formatType || this.element().getAttribute("type");
  }

  maxLength() {
    const maxLength = this.element().getAttribute("data-max-length");
    const extra = this.value().includes("+") ? 3 : 0;
    return (Number(maxLength) || 10) + extra;
  }

  format(event) {
    let result = "";
    const value = this.value().replaceAll(" ", "");
    switch (this.type()) {
      case "tel":
        if (
          (this.valueLength() <= this.maxLength() && event.key == null) ||
          this.valueLength() < this.maxLength()
        ) {
          /**
           * format = "012 34 567 89" or "+261 23 45 678 90";
           */
          value.split("").forEach((str, index) => {
            result += str;
            if (value.includes("+")) {
              if ([3, 5, 7, 10].includes(index)) {
                result += " ";
              }
            } else {
              if ([2, 4, 7].includes(index)) {
                result += " ";
              }
            }
          });
        } else {
          event.preventDefault();
        }
        break;

      default:
        result = value;
        break;
    }
    this.value(result);
    return result;
  }
}

$(function () {
  document.querySelectorAll("[data-format-field]").forEach((element) => {
    new FieldFormatter(element);
  });
});
