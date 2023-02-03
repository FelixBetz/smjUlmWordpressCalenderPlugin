export interface Event {
  name: string;
  description: string;
  startDatetime: Date;
  endDatetime: Date;
  isAllDay: boolean;
  repeatStr: string;
}
