import { KeyboardSpecialPositionType, KeyboardZoneType } from '@/types/KeyboardTypes';

export default interface KeyboardLayoutKeyInterface {
    value: string;
    display: string;
    special?: string;
    specialPosition?: KeyboardSpecialPositionType;
    width?: number;
    zone?: KeyboardZoneType;
}
