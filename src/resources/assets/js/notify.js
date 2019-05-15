export const ITEM_ADDED = 'Item Added';
export const ITEM_REMOVED = 'Item Removed';

export const TYPE_SUCCESS = 'success';
export const TYPE_ERROR = 'error';

export default (msg, type = 'success') => {
    // Use own notification system

    switch (type) {
        case 'success':
            console.log(msg);
            break;
        case 'error':
            console.warn(msg);
            break;
    }
}
