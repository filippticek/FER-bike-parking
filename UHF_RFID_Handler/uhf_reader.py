import codecs

import crcmod


class UHFReader:
  # TODO dodati da se moze postavit adresa. cisto da bude bolji library
  # TODO izvadit cmd id-jeve u konstante

  def __init__(self, address=''):
    self.address = address

  def get_device_overview(self):
    cmd = '040021'
    cmd_with_crc = self.append_crc(cmd)
    return self.decode(cmd_with_crc)

  def parse_device_overview(self, response):
    pass

  def single_tag_read(self):
    cmd = '04000F'
    cmd_with_crc = self.append_crc(cmd)
    return self.decode(cmd_with_crc)

  def parse_single_tag_response(self, response):
    if not self.check_cmd_id_correct(response, '0f'): return {'epc': ''}
    # packet_len = int(response[:2], 16)
    epc = response[14:-6]
    return {'epc': epc}

  def get_inventory(self, q_value='01', session='00', mask_mem='', mask_addr='', mask_len='',
                    mask_data='', adr_TID='', len_TID='', target='', ant='', scan_time=''):
    self._validate_inventory_parameters(adr_TID, ant, len_TID, mask_addr, mask_data, mask_len, mask_mem, q_value,
                                        scan_time,
                                        session, target)
    addr = '00'
    cmd_id = '01'
    data_array = q_value + session + mask_mem + mask_addr + mask_len + mask_data + adr_TID + len_TID + target + ant + scan_time
    cmd_len = self._calculate_len(data_array)
    cmd = cmd_len + addr + cmd_id + data_array
    cmd_with_crc = self.append_crc(cmd)
    return self.decode(cmd_with_crc)

  def ext_read(self, enum='', epc='', mem='02', word_ptr='0000', num='0a', pwd='00000000',
               mask_mem='', mask_adr='', mask_len='', mask_data=''):
    addr = '00'
    cmd_id = '15'
    data_array = enum + epc + mem + word_ptr + num + pwd + mask_mem + mask_adr + mask_len + mask_data
    cmd_len = self._calculate_len(data_array)
    cmd = cmd_len + addr + cmd_id + data_array
    cmd_with_crc = self.append_crc(cmd)
    return self.decode(cmd_with_crc)

  def parse_ext_read(self, response):
    if not self.check_cmd_id_correct(response, '15'): return {'tid': ''}
    tid = response[8:-4]
    return {'tid': tid}

  def _calculate_len(self, data_array):
    cmd_len = hex(len(data_array) // 2 + 4)[2:]
    if len(cmd_len) == 1:
      return '0' + cmd_len
    return cmd_len

  def parse_inventory_response(self, response):
    pass

  def set_GPIO(self, gpio1, gpio2):
    gpio_hex = 0
    if gpio1 and gpio2:
      gpio_hex = 3
    elif gpio1:
      gpio_hex = 1
    elif gpio2:
      gpio_hex = 2

    cmd = '0500460' + str(gpio_hex)
    cmd_with_crc = self.append_crc(cmd)
    return self.decode(cmd_with_crc)

  def get_GPIO(self):
    cmd = '040047'
    cmd_with_crc = self.append_crc(cmd)
    return self.decode(cmd_with_crc)

  def parse_get_GPIO_response(self, response):
    if not response: return False, False
    if not self.check_cmd_id_correct(response, '47'): return False, False
    gpio_hex = response[8:10]
    gpio_bin = bin(int(gpio_hex, 16))[2:4]
    print('gpiobin:', gpio_bin)
    if len(gpio_bin) == 2:
      return gpio_bin[0] == '1', gpio_bin[1] == '1'
    else:
      return False, False

  def _validate_inventory_parameters(self, adr_TID, ant, len_TID, mask_addr, mask_data, mask_len, mask_mem, q_value,
                                     scan_time,
                                     session, target):
    if int(q_value, 16) < 0 or int(q_value, 16) > 15:
      raise ValueError('Q-Value must be between 0 and 15')
    if int(session) < 0 or int(session) > 3:
      raise ValueError('Session value must be in range 00-03. Choose 01 for best results.')
    if mask_mem and (int(mask_mem) < 1 or int(mask_mem) > 3):
      raise ValueError('MaskMem must be 0x01 (EPC memory), 0x02 (TID memory) or 0x03 (User memory)')
    if mask_addr and (int(mask_addr, 16) < 0 or int(mask_addr, 16) > 16383):
      raise ValueError(
        'MaskAddr specifies the start bit address of the mask pattern data. The value ranges from 0 to 16383.')
    if mask_len and (int(mask_len, 16) < 0 or int(mask_len, 16) > 255):
      raise ValueError(
        'MaskLen specifies the bit length of the mask pattern data. The value ranges from 0 to 255')
    if mask_len and int(mask_len, 16) != 0 and int(mask_data, 16) != int(mask_len, 16) / 8 and int(mask_data, 16) != (
            int(mask_len, 16) // 8) + 1:
      raise ValueError(
        'Mask pattern data. The byte length of the MaskData is MaskLen/8. If MaskLen is not 8bits integer times,'
        'the length of MaskData should be int[MaskLen/8]+1 with 0 patching in the low significant location.')
    if adr_TID and (int(adr_TID, 16) < 0 or int(adr_TID, 16) > 255):
      raise ValueError(
        'AdrTID is one byte. It specifies the start word address in TID memory when doing the TID-inventory.')
    if len_TID and (int(len_TID, 16) < 0 or int(len_TID, 16) > 15):
      raise ValueError(
        'LenTID is one byte. It specifies the number of words when doing the TID-inventory. The range is 0~15.')
    if target and (int(target) < 0 or int(target) > 1):
      raise ValueError(
        'Target (Optional parameter) is one byte, 0x00 - Target value is A; 0x01 - Target value is B;'
        'Other values are reserved.')
    if ant and (int(ant, 16) != 128):
      raise ValueError(
        'Ant (Optional parameter) is one byte, 0x80, Other values are reserved.'
      )
    if scan_time and (int(scan_time, 16) < 0 or int(scan_time, 16) > 255):
      raise ValueError(
        'ScanTime (Optional parameter) is one byte,reader will set max scan time to ScanTime*100ms.'
      )

  def append_crc(self, command):
    lsb, msb = self._get_crc_lsb_msb(command)
    return command + lsb + msb

  def _get_crc_lsb_msb(self, command):
    # CRC-16/MCRF4XX
    # POLYNOMIAL = 0x11021
    # PRESET_VALUE = 0xFFFF
    # crc_func = crcmod.mkCrcFun(POLYNOMIAL, initCrc=PRESET_VALUE)
    crc_func = crcmod.predefined.mkCrcFun('crc-16-mcrf4xx')
    crc = crc_func(codecs.decode(command, 'hex'))
    msb = hex(crc)[2:4]
    lsb = hex(crc)[4:6]
    return lsb.upper(), msb.upper()

  def decode(self, cmd_with_crc):
    return codecs.decode(cmd_with_crc, 'hex')

  def check_cmd_id_correct(self, response, param):
    return response[4:6] == param
