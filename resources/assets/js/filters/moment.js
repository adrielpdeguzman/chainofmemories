import moment from 'moment'

export function formatDate(value, format) {
    return moment(value).format(format);
}
