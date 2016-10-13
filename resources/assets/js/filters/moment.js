import moment from 'moment'

/**
 * Format the given date by specified format.
 */
export function formatDate(value, format) {
    return moment(value).format(format);
}
