const tagDataElement = document.getElementById('tags');
const tagData = JSON.parse(tagDataElement.dataset.tagData);

import Tokenfield from './tokenfield';
new Tokenfield({
    el: document.getElementById('tags'),
    items: tagData.tags,
    setItems: tagData.selected_tags,
    itemName: 'tags',
    newItemName: 'new_tags',
    addItemOnBlur: true,
    addItemsOnPaste: true,
    delimiters: [',', ' '],
    minChars: 0
});
