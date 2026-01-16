document.getElementById('js-payment-select').addEventListener('change', function() {
    const selectedText = this.options[this.selectedIndex].text;
    document.getElementById('js-summary-method').textContent = selectedText;
});