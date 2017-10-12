import Tokenfield from './tokenfield';

const tagDataElement = document.getElementById('tags');

if (tagDataElement !== null) {
    let tagData = JSON.parse(tagDataElement.dataset.tagData);

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
}
