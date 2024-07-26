import { format, parseISO } from 'date-fns';

// Function to format date
export function formatDate(dateString) {
  const date = parseISO(dateString); // Converts a date string into a Date object
  return format(date, 'yyyy-MM-dd'); // Formats the date to 'YYYY-MM-DD'
}

// Function to format datetime
export function formatDateTime(dateString) {
  const date = parseISO(dateString); // Converts a date string into a Date object
  return format(date, 'yyyy-MM-dd HH:mm:ss'); // Formats the date to 'YYYY-MM-DD HH:MM:SS'
}

// Function to format date in a more readable form
export function formatDatePretty(dateString) {
  const date = parseISO(dateString); // Converts a date string into a Date object
  return format(date, 'MMMM dd, yyyy'); // Formats the date to 'Month day, Year', e.g., 'April 07, 2021'
}