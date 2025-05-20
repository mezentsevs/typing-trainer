import KeyboardLayoutKeyInterface from '@/interfaces/KeyboardLayoutKeyInterface';
import { KeyboardSpecialPositionEnum, KeyboardZoneEnum } from '@/enums/KeyboardEnums';

export type KeyboardLayoutType = KeyboardLayoutKeyInterface[][];

export type KeyboardSpecialPositionType = KeyboardSpecialPositionEnum | null;

export type KeyboardZoneType = KeyboardZoneEnum | null;
